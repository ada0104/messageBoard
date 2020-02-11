
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ada留言板</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
</head>
<body>
<div id="app" class="container">
    <p>請輸入暱稱：</p>
    <input placeholder="暱稱" v-model="name" clearable></input>
    <p>留言內容：</p>
    <input type="textarea" placeholder="內容" v-model="context" maxlength="30"></input>
    <button class="btn btn-primary" @click="sent">新增留言</button>

    <table class="table">
      <thead>
        <tr>
          <th>#id</th>
          <th>name</th>
          <th>context</th>
          <th>修改</th>
          <th>刪除</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="viewList in viewLists" :key="viewList.id">
          <th>{{viewList.id}}</th>
          <th>{{viewList.name}}</th>
          <th>{{viewList.context}}</th>
          <th><button class="btn btn-warning" data-toggle="modal" data-target="#editData" @click="editData(viewList.id, viewList.name, viewList.context)">修改</button></th>
          <th><button class="btn btn-danger" @click="deleteData(viewList.id)">刪除</button></th>
        </tr>
      </tbody>
      <ul>
    </table>

    <div class="modal fade" id="editData" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <input type="hidden" v-model="editId">
            <label>暱稱：</label>
            <input type="text" v-model="editName">
            <label>內容：</label>
            <input type="textarea" v-model="editContext">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button>
            <button type="button" class="btn btn-primary" @click="update">儲存修改</button>
          </div>
        </div>
      </div>
    </div>
</div>

<script>
  var app = new Vue({
    el: '#app',
    data: {
       name: '',
       context:'',
       viewLists:[],
       editName:'',
       editContext:'',
       editId:'',
    },
    mounted(){
      var self = this;
      this.showData();
    },
    methods:{
        showData:function(){
          var self = this;
          $.ajax({

              type: 'GET',
              url: 'insert.php?',
              data:{
                  'option':'view',
              },
              dataType: 'JSON',
              success: function (data) {
                  self.viewLists = JSON.parse(data);
              },
              error : function(jqXHR, exception) {
                  console.log(jqXHR, exception);
              }
          });
        },
        sent:function(){
            var vm = this;
            $.ajax({
                type: 'POST',
                url: 'insert.php?',
                data:{
                    'option':'insert',
                    'name': this.name,
                    'context': this.context
                },
                dataType: 'JSON',
                success: function (data) {
                    alert(data);
                    vm.showData();
                },
                error : function(jqXHR, exception) {
                    console.log(jqXHR, exception);
                }
            });
        },
        deleteData:function(id){
          var vm = this;
          var id = id;
          $.ajax({
                type: 'DELETE',
                url: 'insert.php?id='+id,
                dataType: 'JSON',
                success: function (data) {
                    alert(data);
                    vm.showData();
                },
                error : function(jqXHR, exception) {
                    console.log(jqXHR, exception);
                }
            });
        },
        editData:function(id,name,context){
          var vm = this;
          vm.editName = name;
          vm.editContext = context;
          vm.editId = id;
        },
        update:function(){
          var vm = this;
          $.ajax({
              type: 'PUT',
              url: 'insert.php?',
              data:{
                  'option':'edit',
                  'updateId': this.editId,
                  'updateName': this.editName,
                  'updateContext': this.editContext
              },
              dataType: 'JSON',
              success: function (data) {
                  alert(data);
                  vm.showData();
              },
              error : function(jqXHR, exception) {
                  console.log(jqXHR, exception);
              }
          });
        }
     },
  });
</script>
</body>
</html>
