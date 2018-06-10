<template>
    <ol>
        <li v-for="todo in todos">
            {{ todo.text }}
        </li>
    </ol>
</template>

<script>

    var data = {
        todos: [
          { text: 'Learn JavaScript' },
          { text: 'Learn Vue' },
          { text: 'Build something awesome' }
        ]
    }

    export default {
        data: () => {
            return data;
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
