<template>
    <div>{{ avgcpc }}</div>
</template>

<script>
    var data = {
        avgcpc: '93,139'
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
