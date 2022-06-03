<template>
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="border-t border-gray-200">
            <div
                class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
                :class="{ 'bg-red-50': todo.deleted_at }"
            >
                <dt class="text-sm font-medium text-gray-500">
                    {{ todo.title }}
                </dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0">
                    {{ todo.desc }}
                </dd>
                <dd class="mt-1 ml-auto text-sm text-gray-900 sm:mt-0">
                    <button
                        type="button"
                        class="rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-1 sm:w-auto sm:text-sm"
                        v-if="todo.deleted_at == null"
                        @click="finishTodo()"
                    >
                        Finish
                    </button>

                    <button
                        type="button"
                        class="rounded-md border border-transparent shadow-sm px-4 py-2 bg-yellow-600 text-base font-medium text-white hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 sm:ml-1 sm:w-auto sm:text-sm"
                        v-if="todo.deleted_at !== null"
                        @click="restoreTodo()"
                    >
                        Restore
                    </button>

                    <button
                        type="button"
                        class="rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-1 sm:w-auto sm:text-sm"
                        v-if="todo.deleted_at !== null"
                        @click="finishTodo(true)"
                    >
                        Delete
                    </button>
                </dd>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ["todo"],
    methods: {
        markAsComplete() {
            axios
                .put(`todo/${this.todo.id}`, {
                    todo: this.todo,
                })
                .then((res) => {
                    if (res.status == 200) {
                        this.$emit("syncTodo");
                    }
                });
        },
        finishTodo(pemanent = false) {
            axios.delete(`todo/${this.todo.id}/${pemanent}`).then((res) => {
                if (res.status == 200) {
                    this.$emit("syncTodo");
                }
            });
        },
        restoreTodo() {
            axios.post(`todo/restore/${this.todo.id}`).then((res) => {
                if (res.status == 200) {
                    this.$emit("syncTodo");
                }
            });
        },
    },
};
</script>
