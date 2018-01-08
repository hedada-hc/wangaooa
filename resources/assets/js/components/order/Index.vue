<template>
	<div class="spread con">
		<el-breadcrumb separator-class="el-icon-arrow-right">
	      	<el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
	      	<el-breadcrumb-item>订单列表</el-breadcrumb-item>
	    </el-breadcrumb>
		<div class="operation">
	        <el-row>
	            <el-col :span="18">
	                <el-row>
	                    <el-col :span="5" class="operation-search-item">
	                        <el-input placeholder="商品ID" v-model="form.goods_id" size="small">
	                            <template slot="prepend">商品ID</template>
	                        </el-input>
	                    </el-col>
	                    <el-col :span="4" class="operation-search-item">
	                        <el-input type="number" placeholder="状态(1/0)" v-model="form.status" size="small">
	                            <template slot="prepend">状态(1/0)</template>
	                        </el-input>
	                    </el-col>
	                    <el-col :span="4" class="operation-search-item">
	                       <el-select v-model="form.level" placeholder="选择权重排序" size="small">
	                         <el-option label="权重降序" value="1"></el-option>
	                         <el-option label="权重升序" value="2"></el-option>
	                         <el-option label="无权重排序" value="0"></el-option>
	                       </el-select>
	                    </el-col>
	                    <el-col :span="2" class="operation-search-item">
	                        <el-button type="primary" size="small" icon="search" @click="getList">查询</el-button>
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
		    :data="orderList"
		    :row-class-name="tableRowClassName"
		    :show-overflow-tooltip="true"
		    style="width: 100%">
		    <el-table-column
		      label="订单号"
		      width="60">
		      <template slot-scope="scope">
		        <span style="margin-left: 10px">{{ scope.row.id }}</span>
		      </template>
		    </el-table-column>
		    <el-table-column
		      label="下单日期"
		      width="180">
		      <template slot-scope="scope">
		        <i class="el-icon-time"></i>
		        <span style="margin-left: 10px">{{ scope.row.created_at }}</span>
		      </template>
		    </el-table-column>
		    <el-table-column
		      label="收货姓名"
		      width="100">
		      <template slot-scope="scope">
		        <span style="margin-left: 10px">{{ scope.row.name }}</span>
		      </template>
		    </el-table-column>
		    <el-table-column
		      label="收货电话"
		      width="120">
		      <template slot-scope="scope">
		        <span style="margin-left: 10px">{{ scope.row.phone }}</span>
		      </template>
		    </el-table-column>
		    <el-table-column
		      label="收货地址"

		      width="220">
		      <template slot-scope="scope">
		        <span style="margin-left: 10px">{{ scope.row.address }}</span>
		      </template>
		    </el-table-column>
		    <el-table-column
		      label="微信号"
		      width="130">
		      <template slot-scope="scope">
		        <span style="margin-left: 10px">{{ scope.row.wechat }}</span>
		      </template>
		    </el-table-column>
		    <el-table-column
		      label="价格"
		      width="100">
		      <template slot-scope="scope">
		        <span style="margin-left: 10px">{{ scope.row.total_price }}</span>
		      </template>
		    </el-table-column>
		    <el-table-column
		      label="支付方式"
		      width="100">
		      <template slot-scope="scope">
		        <span v-if="scope.row.pay_method == 1" style="margin-left: 10px">微信</span>
		        <span v-if="scope.row.pay_method == 2" style="margin-left: 10px">支付宝</span>
		        <span v-if="scope.row.pay_method == 3" style="margin-left: 10px">工行</span>
		        <span v-if="scope.row.pay_method == 4" style="margin-left: 10px">农行</span>
		        <span v-if="scope.row.pay_method == 5" style="margin-left: 10px">建行</span>
		        <span v-if="scope.row.pay_method == 6" style="margin-left: 10px">中行</span>
		        <span v-if="scope.row.pay_method == 7" style="margin-left: 10px">邮政</span>
		      </template>
		    </el-table-column>
		    <el-table-column
		      label="出单来源"
		      width="100">
		      <template slot-scope="scope">
		        <span style="margin-left: 10px">{{ scope.row.source }}</span>
		      </template>
		    </el-table-column>
		    <el-table-column
		      label="订单备注"
		      width="150">
		      <template slot-scope="scope">
		        <span style="margin-left: 10px">{{ scope.row.remark }}</span>
		      </template>
		    </el-table-column>
		    <el-table-column
		      label="快递查询"
		      width="100">
		      <template slot-scope="scope">
		      	<el-popover
				  ref="popover4"
				  placement="right"
				  width="400"
				  trigger="click">
					<el-card class="box-card">
						<div slot="header" class="clearfix">
						    <el-row  :gutter="30">
						    	<el-col style="padding-left:10px;padding-right:0px;padding-bottom:6px" :span="15">
								  	<span >{{scope.row.express}}：{{scope.row.number}}</span>
								</el-col>
				    			<el-col style="float: left;padding-left:10px;padding-right:0px;" :span="13">
								  	<el-switch
								  		style="float: left;"
									  	v-model="express.express_status"
									  	@change="submitExpress(scope.row)"
									  	active-text="已签收"
									  	inactive-text="未签收">
									</el-switch>
								</el-col>
					    	</el-row>
						</div>
						
					  <div v-for="o in 4" :key="o" class="text item">
					    {{'下一站：湖北省武汉市第 ' + o+"栋" }}
					  </div>
					</el-card>
				</el-popover>
				<el-button v-if="scope.row.number > 0" size="mini" type="success" v-popover:popover4>查询快递</el-button>
				<el-button v-else type="danger" size="mini" @click="dialogFormVisible = true">填写单号</el-button>
				<el-dialog title="填写快递信息" :visible.sync="dialogFormVisible">
					<el-form :model="form">
					    <el-form-item label="快递单号" :label-width="formLabelWidth">
					    	<el-row :gutter="20">
				    			<el-col :span="10">
					      			<el-input v-model="express.number" auto-complete="off"></el-input>
					      		</el-col>
				    		</el-row>
					    </el-form-item>
					    <el-form-item label="快递公司" :label-width="formLabelWidth">
					    	<el-row :gutter="20">
					    		<el-col :span="10">
							      	<el-select v-model="express.express" placeholder="请选择快递公司">
								        <el-option label="圆通快递" value="圆通快递"></el-option>
								        <el-option label="顺丰快递" value="顺丰快递"></el-option>
								        <el-option label="中国邮政" value="中国邮政"></el-option>
								        <el-option label="中通快递" value="中通快递"></el-option>
								        <el-option label="申通快递" value="申通快递"></el-option>
								        <el-option label="天天快递" value="天天快递"></el-option>
							      	</el-select>
						      	</el-col>
					      	</el-row>
					    </el-form-item>
				  	</el-form>
					  	<div slot="footer" class="dialog-footer">
						    <el-button @click="dialogFormVisible = false">取 消</el-button>
						    <el-button type="primary" @click="submitExpress(scope.$index)">确 定</el-button>
					  	</div>
				</el-dialog>
		      </template>
		    </el-table-column>
		    <el-table-column
		      label="订单状态"
		      width="100">
		      <template slot-scope="scope">
		        <el-popover trigger="hover" placement="top">
		          <p>姓名: {{ scope.row.name }}</p>
		          <p>住址: {{ scope.row.address }}</p>
		          <div slot="reference" class="name-wrapper">
		            <el-tag v-if="scope.row.express_status == 0" size="medium" type="primary">未发货</el-tag>
		            <el-tag v-if="scope.row.express_status == 1" size="medium" type="warning">已收货</el-tag>
		            <el-tag v-if="scope.row.express_status == 2" size="medium" type="success">签收了</el-tag>
		          </div>
		        </el-popover>
		      </template>
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

<script type="text/javascript">
	export default {
		data(){
			return {
		        form:{goods_id:"",status:""},
		        express:{express:"",number:"",express_status:0},
		        orderList:[],
		        formLabelWidth:"120px",
		        dialogFormVisible:false
			}
		},
		created(){
			this.getList();
		},
		methods:{
			handleEdit(index, row) {
		        console.log(index, row);
		    },
		    handleDelete(index, row) {
		        console.log(index, row);
		        axios.post('/api/order/del',{id:row.id})
		        	.then(res => {
		        		this.getList();
		        		this.$message({message:"删除成功",type:"success"})
		        	})
		        	.catch(erro => {

		        	})
		    },
		    tableRowClassName({row, rowIndex}) {
		        if (rowIndex === 1) {
		          return 'warning-row';
		        } else if (rowIndex === 2) {
		          return 'success-row';
		        }
		        return '';
		    },
		    remove(){

		    },
		    add(){
		    	this.$router.push('/order/add');
		    },
		    getList(){
		    	axios.get('/api/order')
		    		.then(res => {
		    			this.orderList = res.data.result;
		    		})
		    		.catch(err => {

		    		})
		    },
		    submitExpress(id){
		    	console.log(id)
		    	return
		    	this.dialogFormVisible = false;
		    	this.express.id = id
		    	axios.post('/api/order/update',this.express)
		    		.then(res => {
		    			this.$message({message:"快递数据更新成功",type:"success"})
		    			this.getList();
		    		})
		    }
		}
	}
</script>

<style lang="scss">
  .el-table .warning-row {
    background: oldlace;
  }

  .el-table .success-row {
    background: #f0f9eb;
  }
  .con{
    .el-breadcrumb{
      height: 40px;
    }
  }
</style>
