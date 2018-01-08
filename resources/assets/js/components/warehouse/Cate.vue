<template>
	<div class="spread con">
		<el-breadcrumb separator-class="el-icon-arrow-right">
	      	<el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
	      	<el-breadcrumb-item>套餐列表</el-breadcrumb-item>
	    </el-breadcrumb>
	    <div class="operation">
	        <el-row>
	            <el-col :span="18">
	                <el-row>
	                    <el-col :span="5" class="operation-search-item">
	                        <el-input placeholder="员工账号" v-model="user_id" size="small">
	                            <template slot="prepend">员工账号</template>
	                        </el-input>
	                    </el-col>
	                    <el-col :span="2" class="operation-search-item">
	                        <el-button type="primary" size="small" icon="search" @click="getUser">查询</el-button>
	                    </el-col>
	                </el-row>
	            </el-col>
	            <el-col :span="6" style="text-align:right">
	                <el-button type="success" size="small" icon="plus" @click="add">添加</el-button>
	                <el-button type="danger" size="small" icon="delete" @click="remove">删除</el-button>
	            </el-col>
	        </el-row>
	    </div>
		<el-table
		    :data="userData"
		    style="width: 100%">
		    <el-table-column
		      prop="created_at"
		      label="日期"
		      sortable
		      width="180">
		    </el-table-column>
		    <el-table-column
		      prop="name"
		      label="套餐名称"
		      width="180">
		    </el-table-column>
		    <el-table-column
		      prop="price"
		      label="套餐价格"
		      width="180"
		      :formatter="formatter">
		      	<template slot-scope="scope">
		        	<el-tag
			          type="danger"
			          close-transition>{{scope.row.price}}</el-tag>
		      	</template>
		    </el-table-column>
		    <el-table-column
		      prop="goods"
		      label="套餐内商品"
		      :formatter="formatter">
		      	<template slot-scope="scope">
		        	<el-tag
			          type="blue"
			          v-for="item in scope.row.goods"
			          :key="item.name"
			          close-transition>{{item.name}}</el-tag>
		      	</template>
		    </el-table-column>
		    <el-table-column
		      prop="status"
		      label="标签"
		      width="100"
		      :filter-method="filterTag"
		      filter-placement="bottom-end">
		      	<template slot-scope="scope">
		        	<el-tag
			          :type="scope.row.tag === '1' ? 'primary' : 'success'"
			          close-transition>{{scope.row.tag === '1' ? '未使用' : '使用中'}}</el-tag>
		      	</template>
		    </el-table-column>
		</el-table>
	</div>
</template>

<script>
  export default {
    data() {
      return {
	      	user_id:'',
	        userData:[]
      	}
    },
    created(){
    	this.getUser();
    },
    methods: {
	    formatter(row, column) {
	        return row.address;
	    },
		filterTag(value, row) {
	        return row.tag === value;
	    },
	    getUser(){
	    	axios.get('/api/cate')
	    		.then(response => {
	    			if(response.data.status == 200){
	    				this.userData = response.data.result
	    			}else{
	    				this.$notify({
				          	title: '警告',
				          	message: '用户数据获取失败',
				          	type: 'warning'
				        });
	    			}
	    		})
	    },
	    add(){
	    	this.$router.push('/changku/cate/add');
	    },
	    remove(){

	    }
    }
  }
</script>

<style type="text/css" lang="scss">
  	.con{
    	.el-breadcrumb{
      height: 40px;
    	}
  	}
</style>
