<template>
	<div class="spread con">
		<el-breadcrumb separator-class="el-icon-arrow-right">
	      	<el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
	      	<el-breadcrumb-item>数据统计</el-breadcrumb-item>
	    </el-breadcrumb>
	</div>
</template>

<script type="text/javascript">
	export default {
		data(){
			return {
				
			}
		},
		methods:{
			handleOpen(key, keyPath) {
                console.log(key, keyPath);
            },
            handleClose(key, keyPath) {
                console.log(key, keyPath);
            }
		}
	}
</script>