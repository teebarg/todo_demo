<template>
    <div class="container">
        <form v-on:submit.prevent="addTodos()">
            <input class="input" placeholder="enter todo ..." v-model="todoText"/>
            <button class="btnT">Add Todo</button>
        </form>
            <div class="list" v-for="todo in todos" v-bind:key="todo.id">
                {{todo.title}}
            </div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                todoText:'',
                todos:[
                    {
                        id:1,
                        title:'Eat lunch',
                        status: true
                    },{
                        id:2,
                        title:'Eat Dinner',
                        status: false
                    },{
                        id:3,
                        title:'Eat Snack',
                        status: true
                    },
                ],
                nextId:4
            }
        },
        methods:{
            addTodos:function(){
                if(!this.todoText){
                    return alert('please enter a todo');
                } 
                this.todos.push({
                    id:this.nextId++,
                    title:this.todoText,
                    status:false
                });
                this.todoText='';

            },
        }
    }
</script>
<style>
.container{
    margin:60px auto;
    width: 70%;
}
.list{
    background: #f4f4f4;
  padding: 10px;
  border-bottom: 1px #ccc dotted;
  
}
.list:hover{
      background: grey;
        color: #fff;
}
.input{
    width: 90%;
    height: 30px;
    margin: 20px 0;
}
.btnT{
    display: inline;
  border: none;
  background: #555;
  color: #fff;
  padding: 7px 20px;
  cursor: pointer;
}

.btnT:hover {
  background: #666;
}


</style>
