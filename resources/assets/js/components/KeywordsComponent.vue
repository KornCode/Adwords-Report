<template>
	<div class="ads-column">
        <div class="card-action">
            {{ name }}
        </div>
        <div style="margin-top: 20px;">
            <hr>
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

