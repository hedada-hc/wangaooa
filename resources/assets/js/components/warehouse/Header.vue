<template>
	<div>
		<el-aside width="10%">
            <el-menu
				default-active="2"
				class="el-menu-vertical-demo"
				@open="handleOpen"
				@close="handleClose"
				background-color="#FFFFFF"
				text-color="#333333"
				:router="true"
				active-text-color="#000000">
				<el-menu-item index="/changku/index">
	                <i class="el-icon-setting"></i>
	                <span slot="title">商品管理</span>
	            </el-menu-item>
	            <el-menu-item index="/changku/cate">
	                <i class="el-icon-menu"></i>
	                <span slot="title">商品分类</span>
	            </el-menu-item>
	            <el-menu-item index="/changku/stock/add">
	                <i class="el-icon-circle-check"></i>
	                <span slot="title">新增进货</span>
	            </el-menu-item>
	            <el-menu-item index="/changku/count">
	                <i class="el-icon-setting"></i>
	                <span slot="title">销售统计</span>
	            </el-menu-item>
            </el-menu>
        </el-menu>
        </el-aside>
        <el-main>
        	<router-view class="con"></router-view>
        </el-main>
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


<style type="text/css" lang="scss">
	.el-aside{
		float: left;
		.el-menu-vertical-demo{
			height: 1000px;
		}
	}
	.el-main{
		float: left;
		margin-left: 10px;
		margin-top: 10px;
		width: 500px;
		background-color: #ffffff;

	}
</style>