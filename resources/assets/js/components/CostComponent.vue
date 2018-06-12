<template>
    <div>{{ costs }}</div>
</template>

<script>
    var data = {
        costs: '93,139'
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
