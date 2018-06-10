<template>
	<div class="column" style="background-color:#aaa;">
		<div>
			{{ name }}
		</div>
	</div>
</template>

<script>
	var data = {
		name: "keywords"
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

