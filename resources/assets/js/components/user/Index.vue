<template>
	<div class="spread con">
		<el-breadcrumb separator-class="el-icon-arrow-right">
	      	<el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
	      	<el-breadcrumb-item>员工列表</el-breadcrumb-item>
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
		      label="头像"
		      width="100">
		      	<template slot-scope="scope">
		      		<img width="40" height="40" style="border-radius: 22px;" :src="scope.row.headPic" class="avatar">
		      	</template>
		    </el-table-column>
		    <el-table-column
		      prop="username"
		      label="用户名"
		      width="180">
		    </el-table-column>
		    <el-table-column
		      prop="wechat_id"
		      label="微信id"
		      width="180"
		      :formatter="formatter">
		      	<template slot-scope="scope">
		        	<el-tag
			          :type="scope.row.wechat_id ? 'success' : 'info'"
			          close-transition>{{scope.row.wechat_id ? '已绑定' : '未绑定'}}</el-tag>
		      	</template>
		    </el-table-column>
		    <el-table-column
		    	width="100"
		      	prop="user.username"
		      	label="直接上级">
		    </el-table-column>
		    <el-table-column
		      prop="status"
		      label="状态"
		      width="100"
		      :filter-method="filterTag"
		      filter-placement="bottom-end">
		      	<template slot-scope="scope">
		        	<el-tag
			          :type="scope.row.tag === '1' ? 'primary' : 'success'"
			          close-transition>{{scope.row.tag === '1' ? '未使用' : '使用中'}}</el-tag>
		      	</template>
		    </el-table-column>
		    <el-table-column label="操作" >
		      	<template slot-scope="scope">
		      		<el-row :gutter="20">
              			<el-col :span="10">
					        <el-button type="danger" size="mini" icon="plus" v-if="auth.alc.status == 5" @click="editAlc(scope.row)">编辑权限</el-button> 
					        <el-button type="danger" size="mini" icon="delete" @click="remove(scope.row)">删除用户</el-button>
			        	</el-col>
            		</el-row>
		      	</template>
		    </el-table-column>
		</el-table>
	</div>
</template>

<script>
  export default {
  	props:['user'],
    data() {
      return {
	      	user_id:'',
	        userData:[],
	        auth:{alc:{}}
      	}
    },
    created(){
    	this.auth = JSON.parse(this.user);
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
	    	axios.get('/api/user')
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
	    	this.$router.push('/user/add');
	    },
	    remove(row){
            this.$confirm('此操作将永久删除该会员, 是否继续?', '提示', {
		        confirmButtonText: '确定',
		        cancelButtonText: '取消',
		        type: 'warning',
		        center: true
	        }).then(() => {
		        axios.post('/api/user/del',{id:row.id})
	    			then(res => {
	    				this.$message({type:"success",message:"删除成功"})
	    			})
	        }).catch(() => {
		        this.$message({
		            type: 'info',
		            message: '已取消删除'
		        });
	        });

	    },
	    editAlc(row){
	    	this.$router.push('/user/alc/' + row.id );
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
