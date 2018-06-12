<template>
    <div>{{ impression }}</div>
</template>

<script>
    var data = {
        impression: '93,139'
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
