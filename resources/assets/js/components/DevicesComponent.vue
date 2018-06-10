<template>
	<div class="column" style="background-color:#aaa;">
        {{ name }}
    </div>
</template>

<script>
	var data = {
        name: "devices"
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