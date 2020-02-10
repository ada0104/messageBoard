 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ada留言板</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="bootstrap.min.css">
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script> -->
    <!-- bootstrap -->
    <link rel="stylesheet"
          href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
          crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
          integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
          crossorigin="anonymous"></script>
    <script
          src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
          integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
          crossorigin="anonymous"></script>
    <script
          src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
          integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
          crossorigin="anonymous"></script>
    <!-- vue -->
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>

</head>
<body>
<div id="app" class="container">
  
    <p>請輸入暱稱：</p>
    <input placeholder="暱稱"v-model="name"clearable></input>
    <p>留言內容：</p>
    <input type="textarea"placeholder="內容"v-model="context"maxlength="30"></input>
    <button class="btn btn-primary"  @click="sent">新增留言</button>

    <table class="table table-dark">
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
        <tr v-for="viewList in viewList" :key="viewList.id">
          <th >{{viewList.id}}</th>
          <th >{{viewList.name}}</th>
          <th >{{viewList.context}}</th>
          <th ><button class="btn btn-warning"  data-toggle="modal" data-target="#editData" @click="editData(viewList.id, viewList.name, viewList.context)">修改</button></th>
          <th ><button class="btn btn-danger"  @click="deleteData(viewList.id)">刪除</button></th>
        </tr>
      </tbody>
      <ul>
    </table> 

    <div class="modal fade" id="editData" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">

          <div class="modal-body">
            <input type="hidden" v-model="editId">
            <label for="">暱稱：</label>
            <input type="text" v-model="editName">
            <label for="">內容：</label>
            <input type="textarea" v-model="editContext">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button>
            <button type="button" class="btn btn-primary" @click="update()" >儲存修改</button>
          </div>
        </div>
      </div>
    </div>

 
</div>


<script src="jquery.js"></script>
<script>
  var app = new Vue({
    el: '#app',
    //delimiters: ['${', '}'],
    data: {
       name: '',
       context:'',
       viewList:[],
       editName:'',
       editContext:'',
       editId:''

    },
    mounted(){
      var self = this;
      this.showData();
    },
    methods:{
        showData:function(){
          var self = this;
          $.ajax({
              type: "POST",  
              url: "insert.php",
              data:{
                  'option':'view', 
              },
              dataType: "JSON",
              success: function (data) {
                  self.viewList = JSON.parse(data);
                  //console.log(self.viewList);   
              },
              error : function(jqXHR, exception) {
                  console.log(jqXHR, exception);
              }
          });
        },
        sent:function(){
            //let vm=this;
            var vm = this;
            $.ajax({
                type: "POST",  
                url: "insert.php",
                data:{
                    'option':'insert', 
                    'name': this.name,
                    'context': this.context
                },
                dataType: "JSON",
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
          $.ajax({
                type: "POST",  
                url: "insert.php",
                data:{
                    'option':'delete', 
                    'id': id,
                },
                dataType: "JSON",
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
              type: "POST",  
              url: "insert.php",
              data:{
                  'option':'edit', 
                  'updateId': this.editId,
                  'updateName': this.editName,
                  'updateContext': this.editContext
              },
              dataType: "JSON",
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
