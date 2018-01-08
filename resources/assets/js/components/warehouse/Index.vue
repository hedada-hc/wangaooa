<template>
	<div class="spread con">
		<el-breadcrumb separator-class="el-icon-arrow-right">
	      	<el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
	      	<el-breadcrumb-item>商品列表</el-breadcrumb-item>
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
	                        <el-button type="primary" size="small" icon="search" @click="queryGoodsList">查询</el-button>
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
		    :data="goodsData"
		    style="width: 100%">
		    <el-table-column
		      prop="created_at"
		      label="日期"
		      sortable
		      width="180">
		    </el-table-column>
		    <el-table-column
		      prop="name"
		      label="商品名称"
		      width="180">
		    </el-table-column>
		    <el-table-column
		      prop="spec"
		      label="商品规格"
		      width="180">
		    </el-table-column>
		    <el-table-column
		      prop="stock"
		      label="商品库存"
		      width="180">
		    </el-table-column>
		    <el-table-column
		      prop="price"
		      label="商品价格"
		      >
		    </el-table-column>
		    <el-table-column label="操作">
	      		<template slot-scope="scope">
			        <el-button
			          size="mini"
			          @click="handleEdit(scope.$index, scope.row)">编辑</el-button>
			        <el-button
			          size="mini"
			          type="danger"
			          @click="handleDelete(scope.$index, scope.row)">删除</el-button>
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
	        goodsData:[]
      	}
    },
    created(){
    	this.queryGoodsList();
    },
    methods: {
	    formatter(row, column) {
	        return row.address;
	    },
		filterTag(value, row) {
	        return row.tag === value;
	    },
	    queryGoodsList(){
	    	axios.get('/api/goods')
	    		.then(response => {
	    			if(response.data.status == 200){
	    				this.goodsData = response.data.result
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
	    	this.$router.push('/changku/stock/add')
	    },
	    remove(){

	    },
	    handleEdit(index, row) {
	        console.log(index, row);
	    },
	    handleDelete(index, row) {
	        axios.post('/api/goods/del',{
	        	id:row.id
	        })
	        .then(res => {
	        	this.queryGoodsList()
	        })

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
