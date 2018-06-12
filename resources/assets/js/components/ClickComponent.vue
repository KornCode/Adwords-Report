<template>
    <div>{{ clicks }}</div>
</template>

<script>
    var data = {
        clicks: '93,139'
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
