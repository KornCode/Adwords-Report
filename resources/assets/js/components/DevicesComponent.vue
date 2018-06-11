<template>
	<div class="ads-column">
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