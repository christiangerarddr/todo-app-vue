<template>
    <div class="pr-5 py-5 grid grid-cols-2 gap-4">
        <div>
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                Todo List
            </h3>
            <p class="mt-1 text-sm text-gray-500">
                Fun Things to Do When Bored To Help You Stay Sane.
            </p>
            <p class="mt-2">
                <button
                    type="button"
                    class="rounded-md border border-transparent shadow-sm px-4 py-2 bg-gray-600 text-base font-medium text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:w-auto sm:text-sm"
                    @click="withFinished()"
                >
                    Show Finished
                </button>
            </p>
        </div>
        <div>
            <add-edit-todo v-on:syncTodo="getTodos()" />
        </div>
    </div>
    <ul class="list-group m-auto">
        <list-todo
            :todo="todo"
            v-on:syncTodo="getTodos()"
            v-for="todo in todos"
            :key="todo.id"
            class="m-auto my-1 text-justify text-wrap"
        />
    </ul>
</template>

<script>
import addEditTodo from "./AddEdit";
import listTodo from "./List";

export default {
    components: {
        addEditTodo,
        listTodo,
    },

    data: function () {
        return {
            todos: [],
        };
    },
    methods: {
        getTodos() {
            axios
                .get("/todos")
                .then((res) => {
                    this.todos = res.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        withFinished() {
            axios
                .post("/todo/withFinished")
                .then(() => {
                    this.getTodos()
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
    created() {
        this.getTodos();
    },
};
</script>
