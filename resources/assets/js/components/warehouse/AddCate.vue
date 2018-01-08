<template>
  <div class="spread con">
    <el-breadcrumb separator-class="el-icon-arrow-right">
      <el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
      <el-breadcrumb-item>新增套餐</el-breadcrumb-item>
    </el-breadcrumb>
    <el-form :model="formData" ref="formData" label-width="100px" class="demo-dynamic">
        <el-form-item
        label="套餐名称"
        :rules="[{ required: true, message: '请输入套餐名称', trigger: 'blur' }]">
        <el-row :gutter="20">
          <el-col :span="10">
            <el-input placeholder="请输入套餐名称" prefix-icon="el-icon-edit-outline" v-model="formData.name"></el-input>
          </el-col>
        </el-row>
        </el-form-item>
        <el-form-item
          label="套餐价格">
            <el-row :gutter="20">
                <el-col :span="5">
                    <el-input placeholder="请输入套餐价格" type="text" v-model.number="formData.price" auto-complete="off"></el-input>
                </el-col>
            </el-row>
        </el-form-item>
        <el-form-item
          v-for="(item, index) in formData.goods"
          :label="'套餐内商品'"
          :key="Date.now()">
            <el-row :gutter="20">
                <el-col :span="3">
                    <el-select v-model="item.goods_id" clearable placeholder="请选择">
                        <el-option
                          v-for="item in goodsList"
                          :key="item.id"
                          :label="item.name"
                          :value="item.id">
                        </el-option>
                    </el-select>
                </el-col>
                <el-col :span="3">
                    <el-input-number v-model="item.count" @change="handleChange" :min="1" :max="10" label="描述文字"></el-input-number>
                </el-col>
                <el-col :span="4">
                    <el-button type="danger" icon="el-icon-delete" @click.prevent="removeDomain(item)">删除</el-button>
                </el-col>
            </el-row>
        </el-form-item>
        
        <el-form-item>
            <el-button type="primary" @click="submitForm('formData')">提交</el-button>
            <el-button type="success" icon="el-icon-circle-plus" @click="pushGoods">附加商品</el-button>
            <el-button @click="resetForm('formData')">重置</el-button>
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
            goodsList:[],
            formData: {
                goods: [{
                    goods_id:''
                }],
                name: '',
                price: '',
            }
        };
    },
    created(){
        this.queryGoodsList();
        this.queryGoodsList();
    },
    methods: {
        submitForm(formName) {
            this.$refs[formName].validate((valid) => {
                if(valid) {
                    axios.post('/api/cate/add',{
                      data:this.formData
                    })
                    .then(response => {
                        if(response.data.status == 200){
                            this.$router.push('/changku/cate');
                        }
                      console.log(response.data.result)
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
            var index = this.formData.domains.indexOf(item)
            if (index !== -1) {
                this.formData.domains.splice(index, 1)
            }
        },
        handleChange(value) {
            console.log(value);
        },
        pushGoods(){
            this.formData.goods.push({
                goods_id:''
            });
            console.log( this.formData.goods)
        },
        queryGoodsList(){
            axios.get('/api/goods')
                .then(response => {
                    console.log(response.data.result)
                    this.goodsList = response.data.result
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

