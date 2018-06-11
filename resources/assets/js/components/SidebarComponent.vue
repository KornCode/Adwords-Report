<template>
    <div>
        {{ message }}
    </div>
</template>

<script>
    var data = {
        // todos: [
        //   { text: 'Learn JavaScript' },
        //   { text: 'Learn Vue' },
        //   { text: 'Build something awesome' }
        // ]
        message: 'Hello Vue!'
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
