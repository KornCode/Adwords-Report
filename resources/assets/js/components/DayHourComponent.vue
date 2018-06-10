<template>
	<div class="column" style="background-color:#bbb;">{{ name }}</div>
</template>

<script>
	var data = {
        name: "day-hour"
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