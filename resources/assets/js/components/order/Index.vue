<template>
	<div class="spread con">
		<el-breadcrumb separator-class="el-icon-arrow-right">
	      	<el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
	      	<el-breadcrumb-item>订单列表</el-breadcrumb-item>
	    </el-breadcrumb>
		<div class="operation">
	        <el-row>
	            <el-col :span="17">
	                <el-row :gutter="10">
	                    <el-col :span="5" class="operation-search-item">
	                        <el-input placeholder="订单号" v-model="form.goods_id" size="small">
	                            <template slot="prepend">订单号</template>
	                        </el-input>
	                    </el-col>
	                    <el-col :span="4" class="operation-search-item">
	                       <el-select v-model="form.status" placeholder="选择排序" size="small">
	                         <el-option label="已签收在前" value="2"></el-option>
	                         <el-option label="未发货在前" value="1"></el-option>
	                         <el-option label="无条件" value="-1"></el-option>
	                       </el-select>
	                    </el-col>
	                    <el-col :span="4" class="operation-search-item">
	                       <el-select v-model="form.take" placeholder="显示单状态订单" size="small">
	                         <el-option label="只查看已签收" value="1"></el-option>
	                         <el-option label="只查看已发货" value="2"></el-option>
	                         <el-option label="只查看未签收" value="3"></el-option>
	                         <el-option label="只查看微信支付" value="4"></el-option>
	                         <el-option label="只查看支付宝支付" value="5"></el-option>
	                         <el-option label="只查看复购订单" value="6"></el-option>
	                         <el-option label="无条件" value="-1"></el-option>
	                       </el-select>
	                    </el-col>
	                    <el-col :span="2" class="operation-search-item">
	                        <el-date-picker
	                        	size="small"
							    v-model="selectDate"
							    type="daterange"
							    align="right"
							    unlink-panels
							    range-separator="至"
							    start-placeholder="开始日期"
							    end-placeholder="结束日期"
							    :picker-options="pickerOptions2">
						    </el-date-picker>
	                    </el-col>
	                </el-row>
	            </el-col>
	            <el-col :span="6" style="text-align:right">
	                <el-button type="primary" size="small" icon="search" @click="getList">查询</el-button>
	                <el-button type="success" size="small" icon="search" @click="impExcel">导出excel</el-button>
	            </el-col>
	        </el-row>
	    </div>
		<el-table
			:summary-method="getSummaries"
    		show-summary
		    :data="orderList"
		    :row-class-name="tableRowClassName"
		    :show-overflow-tooltip="true"
		    style="width: 100%">
		    <el-table-column
		      	label="订单号"
		      	width="80">
		      <template slot-scope="scope">
		        <span style="margin-left: 10px">{{ scope.row.id ? scope.row.id : '无' }}</span>
		      </template>
		    </el-table-column>
		    <el-table-column
		      label="收货电话"
		      width="120">
		      <template slot-scope="scope">
		        <span style="margin-left: 10px">{{ scope.row.phone ? scope.row.phone : '无' }}</span>
		      </template>
		    </el-table-column>
		    <el-table-column
		      label="收货地址"
		      width="220">
		      <template slot-scope="scope">
		        <span style="margin-left: 10px">{{ scope.row.address ? scope.row.address : '无' }}</span>
		      </template>
		    </el-table-column>
		    <el-table-column
		      label="收货姓名"
		      width="100">
		      <template slot-scope="scope">
		        <span style="margin-left: 10px">{{ scope.row.name ? scope.row.name : '无' }}</span>
		      </template>
		    </el-table-column>
		    <el-table-column
		      label="微信号"
		      sortable
		      width="130">
		      <template slot-scope="scope">
		        <span style="margin-left: 10px">{{ scope.row.wechat ? scope.row.wechat : '无' }}</span>
		      </template>
		    </el-table-column>
		    <el-table-column
		      label="价格"
		      sortable
		      width="100">
		      <template slot-scope="scope">
		        <span style="margin-left: 10px">{{ scope.row.total_price ? scope.row.total_price : '无' }}</span>
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
		        <span v-if="!scope.row.pay_method" style="margin-left: 10px">无</span>
		      </template>
		    </el-table-column>
		    <el-table-column
		      label="出单来源"
		      width="100">
		      <template slot-scope="scope">
		        <span style="margin-left: 10px">{{ scope.row.source ? scope.row.source : '无' }}</span>
		      </template>
		    </el-table-column>
		    <el-table-column
		      label="订单备注"
		      width="150">
		      <template slot-scope="scope">
		        <span style="margin-left: 10px">{{ scope.row.remark ? scope.row.remark : '无' }}</span>
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
								  	<span >{{scope.row.express ? scope.row.express : '无'}}：{{scope.row.number ? scope.row.number : '无'}}</span>
								</el-col>
				    			<el-col style="float: left;padding-left:10px;padding-right:0px;" :span="13">
								  	<el-switch
								  		v-if="scope.row.express_status <= 1"
								  		style="float: left;"
									  	v-model="express.express_status"
									  	@change="submitExpress(scope.row.id)"
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
				<el-popover
					ref="expressinfo"
					placement="right"
					width="400"
					trigger="click">
					<el-form :model="form">
					    <el-form-item label="快递单号" :label-width="formLabelWidth">
					    	<el-row :gutter="20">
				    			<el-col :span="20">
					      			<el-input v-model="express.number" auto-complete="off"></el-input>
					      		</el-col>
				    		</el-row>
					    </el-form-item>
					    <el-form-item label="快递公司" :label-width="formLabelWidth">
					    	<el-row :gutter="20">
					    		<el-col :span="20">
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
					    <el-row :gutter="20">
					    	<el-col :span="10" :offset="8">
							    <el-button size="small" @click="dialogFormVisible = false">取 消</el-button>
							    <el-button size="small" type="primary" @click="submitExpress(scope.row.id)">发 货</el-button>
					    	</el-col>
					    </el-row>
				  	</el-form>
				</el-popover>
				<el-button v-if="scope.row.number <= 0" type="danger" size="mini" v-popover:expressinfo>填写单号</el-button>
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
		    <el-table-column
		      label="下单日期"
		      width="180">
		      <template slot-scope="scope">
		        <i class="el-icon-time"></i>
		        <span style="margin-left: 10px">{{ scope.row.created_at ? scope.row.created_at : '无' }}</span>
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
		<el-row :gutter="20">
		  	<el-col :span="12" :offset="8">
		  		<div class="grid-content bg-purple">
					<el-pagination
					    @size-change="handleSizeChange"
					    @current-change="handleCurrentChange"
					    :current-page.sync="currentPage"
					    :page-size="30"
					    layout="total, prev, pager, next"
					    :total="totalPage">
					</el-pagination>
				</div>
		  	</el-col>
		</el-row>  
	</div>
</template>

<script type="text/javascript">
	import moment from 'moment';
	export default {
		data(){
			return {
				pickerOptions2: {
		          shortcuts: [{
		            text: '最近一周',
		            onClick(picker) {
		              const end = new Date();
		              const start = new Date();
		              start.setTime(start.getTime() - 3600 * 1000 * 24 * 7);
		              picker.$emit('pick', [start, end]);
		            }
		          }, {
		            text: '最近一个月',
		            onClick(picker) {
		              const end = new Date();
		              const start = new Date();
		              start.setTime(start.getTime() - 3600 * 1000 * 24 * 30);
		              picker.$emit('pick', [start, end]);
		            }
		          }, {
		            text: '最近三个月',
		            onClick(picker) {
		              const end = new Date();
		              const start = new Date();
		              start.setTime(start.getTime() - 3600 * 1000 * 24 * 90);
		              picker.$emit('pick', [start, end]);
		            }
		          }]
		        },
		        currentPage: 1,
		        totalPage: 0,
		        selectDate:'',
		        form:{goods_id:"",status:"",take:""},
		        express:{express:"",number:"",express_status:0},
		        orderList:[],
		        formLabelWidth:"120px",
		        dialogFormVisible:false,
		        visible2:false,
		        select:-1,
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
		        if (row.express_status == 2) {
		          return 'success-row';
		        } else if (row.express_status === 1) {
		          return 'warning-row';
		        }
		        return '';
		    },
		    remove(){

		    },
		    add(){
		    	this.$router.push('/order/add');
		    },
		    getList(pages = false){
		    	this.currentPage = pages >= 1 ? pages : this.currentPage
		    	var params = {
		    		page:this.currentPage
		    	}
		    	if(this.form.goods_id != ""){
		    		params.goods_id = this.form.goods_id
		    	}
		    	if(this.form.status != "" && this.form.status != -1){
		    		params.status = this.form.status
		    	}
		    	if(this.form.take != "" && this.form.take != -1){
		    		params.take = this.form.take
		    	}
		    	axios.get('/api/order', {params:params})
		    		.then(res => {
		    			this.totalPage = res.data.total;
		    			this.orderList = res.data.result;
		    		})
		    		.catch(err => {

		    		})
		    },
		    submitExpress(id){
		    	this.dialogFormVisible = false;
		    	this.express.id = id
		    	axios.post('/api/order/update',this.express)
		    		.then(res => {
		    			this.$message({message:"快递数据更新成功",type:"success"})
		    			this.getList();
		    		})
		    },
		    impExcel(){
		    	if(this.selectDate.length >= 1){
		    		//window.location.href = url;
			    	this.selectDate[0] = moment(this.selectDate[0]).format('YYYY-MM-DD') + " 00:00:00";
			    	this.selectDate[1] = moment(this.selectDate[1]).format('YYYY-MM-DD') + " 59:59:59";
			    	this.$message({message:"已提交导出数据，正在生成导出表格",type:"success"})
			    	window.location.href = '/api/order/excel?start='+this.selectDate[0]+'&end='+this.selectDate[1];
			    	return
			    	axios.post('/api/order/excel',{data:this.selectDate})
			    		.then(res => {
			    			this.$message({message:"已提交导出数据，正在生成导出表格",type:"success"})
			    		})
			    		.catch(err => {

			    		})
		    	}else{
		    		this.$message.error("请选择导出时间")
		    	}
		    },
		    getSummaries(param){
		    	const { columns, data } = param;
		        const sums = [];
		        var price = 0
		        var total_price = 0
		        for(let index in data){
		        	
			        price += parseInt(data[index].price);
			        total_price += parseInt(data[index].total_price);
		        }
		        sums.push('销售统计')
		        sums.push('应收总额:' + total_price)
		        sums.push('已付定金:' + price)
		        return sums;
		    },
		    handleSizeChange(val) {
		        console.log(`每页 ${val} 条`);
		    },
		    handleCurrentChange(val) {
		        console.log(`当前页: ${val}`);
		        this.getList(val)
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
