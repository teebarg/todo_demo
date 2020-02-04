<template>
    <div class="container">
        <form v-on:submit.prevent="addTodos()">
            <input class="input" placeholder="enter todo ..." v-model="todoText"/>
            <button class="btnT">Add Todo</button>
        </form>
            <div class="list" v-for="todo in todos" v-bind:key="todo.id">
                {{todo.todo}}
            </div>
    </div>
</template>

<script>
import axios from "axios";
    export default {
        data(){
            return{
                todoText:'',
                todos:[],
            }
        },
        methods:{
            addTodos:function(){
                if(!this.todoText){
                    return alert('please enter a todo');
                } 
                const todos ={
                    todo:this.todoText,
                    status:0
                };
                console.log('payload',todos);
                axios
                .post("api/todo",todos)
                .then(res => this.todos.push(res.data[0]))
                .catch(err => alert(err));
                this.todoText='';
            },


        },
        created() {
        axios.get('/api/todos')
        .then(res => this.todos = res.data.todos)
        .catch(err => console.log(err));
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
