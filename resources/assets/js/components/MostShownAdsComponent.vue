<template>
	<div class="ads-column">
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