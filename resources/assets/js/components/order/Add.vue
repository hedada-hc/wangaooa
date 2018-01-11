<template>
	<div class="spread con">
		<el-breadcrumb separator-class="el-icon-arrow-right">
		  <el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
		  <el-breadcrumb-item>新增订单</el-breadcrumb-item>
		</el-breadcrumb>
		<el-form :model="submitData" ref="submitData" label-width="100px" class="demo-dynamic">
			<el-form-item
			    label='选择套餐'>
			    <el-row :gutter="20">
				  	<el-col :span="3">
					    <el-select @change="selectPackage($event)" v-model="submitData.order_name" clearable placeholder="请选择">
						    <el-option
						      v-for="item in package.options"
						      :key="item.id"
						      :label="item.name"
						      :value="item">
						    </el-option>
						</el-select>
					</el-col>
		    	</el-row>
			</el-form-item>
		  	<el-form-item
		    label="套餐名称"
		    :rules="[{ required: true, message: '请输入套餐名称', trigger: 'blur' }]">
		    <el-row :gutter="20">
		    	<el-col :span="10">
		    		<el-input placeholder="请输入内容"  prefix-icon="el-icon-edit-outline" v-model="submitData.order_name"></el-input>
		   		</el-col>
		    </el-row>
			</el-form-item>
			<el-form-item
			    label="付款金额"
			    :rules="[{ required: true, message: '价格不能为空'},{ type: 'number', message: '价格必须为数字值'}]">
			    <el-row :gutter="20">
		    		<el-col :span="5">
			    		<el-input type="text" size="small" placeholder="请输入订单金额" v-model.number="submitData.total_price" auto-complete="off"></el-input>
				    </el-col>
			    </el-row>
			</el-form-item>
			<el-form-item
			    label="已收款金额"
			    :rules="[{ required: true, message: '价格不能为空'},{ type: 'number', message: '价格必须为数字值'}]">
			    <el-row :gutter="20">
		    		<el-col :span="5">
			    		<el-input type="text" size="small" placeholder="请输入已收款金额" v-model.number="submitData.price" auto-complete="off"></el-input>
				    </el-col>
			    </el-row>
			</el-form-item>
			
			<el-form-item
		    label="付款状态">
		    <el-row :gutter="20">
		    	<el-col :span="10">
		    		<el-radio size="small" v-model="submitData.pay_status" label="1" border >货到付款</el-radio>
    				<el-radio size="small" v-model="submitData.pay_status" label="2" border >直接付款</el-radio>
    				<el-radio size="small" v-model="submitData.pay_status" label="3" border >已付定金</el-radio>
		   		</el-col>
		    </el-row>
			</el-form-item>
			<el-form-item
		    label="支付方式">
		    <el-row :gutter="20">
		    	<el-col :span="15">
					<el-radio size="small" v-model="submitData.pay_method" label="1" border >微信</el-radio>
    				<el-radio size="small" v-model="submitData.pay_method" label="2" border >支付宝</el-radio>
    				<el-radio size="small" v-model="submitData.pay_method" label="3" border >工行</el-radio>
    				<el-radio size="small" v-model="submitData.pay_method" label="4" border >农行</el-radio>
    				<el-radio size="small" v-model="submitData.pay_method" label="5" border >建行</el-radio>
    				<el-radio size="small" v-model="submitData.pay_method" label="6" border >中行</el-radio>
    				<el-radio size="small" v-model="submitData.pay_method" label="7" border >邮政</el-radio>
		   		</el-col>
		    </el-row>
			</el-form-item>
			<el-form-item
		    label="快递状态">
		    <el-row :gutter="20">
		    	<el-col :span="10">
		    		<el-radio-group v-model="submitData.express_status" size="small">
						<el-radio-button label="0">未发货</el-radio-button>
						<el-radio-button label="1">已发货</el-radio-button>
						<el-radio-button label="2">签收了</el-radio-button>
				    </el-radio-group>
		   		</el-col>
		    </el-row>
			</el-form-item>
			<el-form-item
		    label="出单来源">
		    <el-row :gutter="20">
		    	<el-col :span="10">
		    		<el-radio-group v-model="submitData.source" size="small">
						<el-radio-button label="微信">微信</el-radio-button>
						<el-radio-button label="QQ">QQ</el-radio-button>
						<el-radio-button label="电话">电话</el-radio-button>
						<el-radio-button label="报纸">报纸</el-radio-button>
				    </el-radio-group>
		   		</el-col>
		    </el-row>
			</el-form-item>
			<el-form-item
		    	label="微信号"
		    	:rules="[{ required: true, message: '请输入微信号', trigger: 'blur' }]">
			    <el-row :gutter="20">
			    	<el-col :span="10">
			    		<el-input size="small" placeholder="请输入微信号" prefix-icon="el-icon-edit-outline" v-model="submitData.wechat"></el-input>
			   		</el-col>
			    </el-row>
			</el-form-item>
			<el-form-item
		    	label="收货人姓名"
		    	:rules="[{ required: true, message: '请输入收货人姓名', trigger: 'blur' }]">
			    <el-row :gutter="20">
			    	<el-col :span="10">
			    		<el-input size="small" placeholder="请输入收货人姓名" prefix-icon="el-icon-edit-outline" v-model="submitData.name"></el-input>
			   		</el-col>
			    </el-row>
			</el-form-item>
			<el-form-item
		    	label="收货人电话"
		    	:rules="[{ required: true, message: '请输入收货人电话', trigger: 'blur' }]">
			    <el-row :gutter="20">
			    	<el-col :span="10">
			    		<el-input size="small" placeholder="请输入收货人电话" prefix-icon="el-icon-edit-outline" v-model="submitData.phone"></el-input>
			   		</el-col>
			    </el-row>
			</el-form-item>
			<el-form-item
		    	label="收货人地址"
		    	:rules="[{ required: true, message: '请输入收货人地址', trigger: 'blur' }]">
			    <el-row :gutter="20">
			    	<el-col :span="10">
			    		<el-input size="small" placeholder="请输入收货人地址" prefix-icon="el-icon-edit-outline" v-model="submitData.address"></el-input>
			   		</el-col>
			    </el-row>
			</el-form-item>
			<el-form-item
			    label='快递公司'>
			    <el-row :gutter="20">
				  	<el-col :span="3">
					    <el-select size="small" v-model="submitData.express" clearable placeholder="请选择">
						    <el-option
						      v-for="item in expressData"
						      :key="item.value"
						      :label="item.value"
						      :value="item.value">
						    </el-option>
						</el-select>
					</el-col>
		    	</el-row>
			</el-form-item>
			<el-form-item
		    	label="快递单号">
			    <el-row :gutter="20">
			    	<el-col :span="10">
			    		<el-input size="small" placeholder="请输入快递单号" prefix-icon="el-icon-edit-outline" v-model="submitData.number"></el-input>
			   		</el-col>
			    </el-row>
			</el-form-item>
			<el-form-item
		    	label="订单备注">
			    <el-row :gutter="20">
			    	<el-col :span="10">
			    		<el-input placeholder="请输入备注信息" prefix-icon="el-icon-edit-outline" v-model="submitData.remark"></el-input>
			   		</el-col>
			    </el-row>
			</el-form-item>
		  	<el-form-item
			    v-for="(domain, index) in submitData.add_goods"
			    :label="'套餐内商品'"
			    :key="domain.id">
			    <el-row :gutter="20">
				  	<el-col :span="3">
					    <el-select  v-model="domain.select" @change="addGoodsPackage($event)" clearable placeholder="请选择">
						    <el-option
						      v-for="item in goodsList"
						      :key="item.id"
						      :label="item.name"
						      :value="item.id">
						    </el-option>
						</el-select>
					</el-col>
				  	<el-col :span="3">
			    		<el-input-number v-model="domain.value" @change="handleChange" :min="1" :max="10" label="描述文字"></el-input-number>
			    	</el-col>
			    	<el-col :span="4">
			    		<el-button type="danger" icon="el-icon-delete" @click.prevent="removeDomain(domain)">删除</el-button>
			    	</el-col>
		    	</el-row>
			</el-form-item>
			
			<el-form-item>
			    <el-button type="primary" @click="submitForm('submitData')">提交</el-button>
			    <el-button type="success" icon="el-icon-circle-plus" @click="addDomain">附加商品</el-button>
			    <el-button @click="resetForm('submitData')">重置</el-button>
		  </el-form-item>
		</el-form>
	</div>
</template>

<script>
  export default {
    data() {
      return {
        ruleForm: {
          name: '',
          region: '',
          delivery: false,
          type: [],
        },
        package: {
        	options:[]
        },
        expressData:[
        	{value:"圆通快递"},
        	{value:"顺丰快递"},
        	{value:"中国邮政"},
        	{value:"中通快递"},
        	{value:"申通快递"},
        	{value:"天天快递"},
        ],
        addGoodsSelect:"",
        goodsList:[],
        submitData:{
        	order_name:'',
        	name:'',
        	address:'',
        	phone:'',
        	wechat:'',
        	total_price:0,
        	price:'',
        	pay_status:'',
        	pay_method:'',
        	source:'',
        	remark:'',
        	express:'',
        	number:'',
        	express_status:'',
        	goods_id:'',
        	cate_goods_id:"",
        	add_goods:[],
        }
      };
    },
    created(){
    	this.queryPackage();
    	this.queryGoods();
    },
    methods: {
      	submitForm(formName) {
	        this.$refs[formName].validate((valid) => {
	          	if(valid) {
	            	axios.post('/api/order/add',{
	            		data:this.submitData
	            	})
	            		.then(res => {
	            			this.$message({message:"订单提交成功",type:"success"})
	            			this.$router.push("/order/index");
	            		})
	            		.catch(error => {

	            		})
	          	}else {
	            	console.log('error submit!!');
	            	return false;
	          	}
	        });
      	},
      	resetForm(formName) {
        	this.$refs[formName].resetFields();
      	},
      	removeDomain(item) {
	        var index = this.submitData.package.indexOf(item)
	        if (index !== -1) {
	          	this.submitData.package.splice(index, 1)
	        }
      	},
      	addDomain() {
        	this.submitData.add_goods.push({
	          	value: 1,
		        select:"",
        	});
        	console.log(this.submitData.add_goods)
      	},
      	handleChange(value) {
        	console.log(value);
      	},
      	queryPackage(){
      		axios.get('/api/cate')
      			.then(res => {
      				console.log(res)
      				this.package.options = res.data.result
      			})
      			.catch(e => {
      				console.log(e)
      			})
      	},
      	queryGoods(){
      		axios.get('/api/goods')
      			.then(res => {
      				this.goodsList = res.data.result
      			})
      			.catch(error => {

      			})
      	},
      	addGoods(){
      		this.submitData.add_goods.push(this.addGoodsSelect)
      		this.addGoodsSelect = null
      	},
      	selectPackage(e){
      		this.submitData.goods_id = e.id;
      		this.submitData.order_name = e.name;
      		this.submitData.total_price = parseInt(e.price);
      		this.submitData.cate_goods_id = e.cate_goods_id
      	},
      	addGoodsPackage(e){
      		this.submitData.total_price += parseInt(e.price)
      	}
    }
  }
</script>

<style type="text/css" lang="scss">
	.con{
		.el-breadcrumb{
			height: 40px;
		}
		.demo-dynamic{
			.el-form-item{
				margin-bottom:14px;
			}
		}
	}
</style>

