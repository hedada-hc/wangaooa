<template>
	<h1>登录页面</h1>
</template>

<script type="text/javascript">
	export default {
		mounted(){
			this.open4();
			window.location.href = "/login"
		},
		methods:{
			open4() {
		        this.$notify({
		          title: '警告',
		          message: '请先登录',
		          type: 'warning'
		        });
		    }
		}
	}
</script>