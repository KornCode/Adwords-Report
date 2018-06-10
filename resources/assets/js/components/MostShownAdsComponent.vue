<template>
	<div class="column" style="background-color:#bbb;">
        {{ name }}
    </div>
</template>

<script>
	var data = {
        name: "most-shown"
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