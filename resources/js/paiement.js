const vm = Vue.createApp({
    data() {
        return {
            message: 'Bonjour',
            todos: ['Banane', 'Mangue', 'Orange']
        }
    },

    methods: {
        inverser() {
            this.todos.reverse()
        },

        ajouter() {
            this.todos.push(this.message);
            this.message = '';
        }
    }
});

vm.component('note', {
    props: ['content'],
    template: `<p>{{ content }}</p>`
})

vm.mount('#app')