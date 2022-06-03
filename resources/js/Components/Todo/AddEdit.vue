<template>
    <button
        type="button"
        class="float-right rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-1 sm:w-auto sm:text-sm"
        @click="hideForm = !hideForm"
    >
        Add Todo
    </button>
    <div
        class="relative z-10"
        :class="{'hidden' : hideForm}"
        aria-labelledby="modal-title"
        role="dialog"
        aria-modal="true"
    >
        <div
            class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
        ></div>

        <div class="fixed z-10 inset-0 overflow-y-auto">
            <div
                class="flex items-end sm:items-center justify-center min-h-full p-4 text-center sm:p-0"
            >
                <div
                    class="relative bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-lg sm:w-full"
                >
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="shadow-lg sm:rounded-md sm:overflow-hidden">
                            <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                                <div class="grid grid-cols-1">
                                    <div class="col-span-3 sm:col-span-2">
                                        <label
                                            class="block text-sm font-medium text-gray-700"
                                        >
                                        </label>
                                        <div
                                            class="mt-1 flex rounded-md shadow-sm"
                                        >
                                            <span
                                                class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm"
                                            >
                                                Title
                                            </span>
                                            <input
                                                type="text"
                                                v-model="todo.title"
                                                class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300"
                                            />
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <div class="mt-1">
                                        <textarea
                                            id="about"
                                            name="about"
                                            rows="3"
                                            v-model="todo.desc"
                                            class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md"
                                        ></textarea>
                                    </div>
                                    <p class="mt-2 text-sm text-gray-500">
                                        Brief description for your Todo.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div
                        class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse"
                    >
                        <button
                            type="button"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm"
                            @click="addtodo()"
                        >
                            Create
                        </button>
                        <button
                            type="button"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                            @click="hideForm = !hideForm"
                        >
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data: function () {
        return {
            todo: {
                title: "",
                desc: "",
            },
            hideForm: true
        };
    },
    methods: {
        addtodo() {
            if (this.todo.title == "") {
                return;
            }
            axios
                .post("todo/store", {
                    todo: this.todo,
                })
                .then((res) => {
                    if (res.status == 201) {
                        this.todo.name = "";
                        this.$emit("syncTodo");
                    }
                    this.hideForm = !this.hideForm
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
};
</script>

<style scoped>
.active {
    color: white;
    background-color: blue;
}
.inactive {
    color: gray;
}
</style>
