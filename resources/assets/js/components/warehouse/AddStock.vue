<template>
  <div class="spread con">
    <el-breadcrumb separator-class="el-icon-arrow-right">
      <el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
      <el-breadcrumb-item>新增商品</el-breadcrumb-item>
    </el-breadcrumb>
    <el-form :model="dynamicValidateForm" ref="dynamicValidateForm" label-width="100px" class="demo-dynamic">
        <el-form-item
        label="商品名称"
        :rules="[{ required: true, message: '请输入商品名称', trigger: 'blur' }]">
        <el-row :gutter="20">
          <el-col :span="10">
            <el-input placeholder="请输入内容" prefix-icon="el-icon-edit-outline" v-model="dynamicValidateForm.name"></el-input>
          </el-col>
        </el-row>
      </el-form-item>
      <el-form-item
        label="规格"
        :rules="[{ required: true, message: '请输入商品规格', trigger: 'blur' }]">
        <el-row :gutter="20">
          <el-col :span="10">
            <el-input placeholder="请输入内容" prefix-icon="el-icon-edit-outline" v-model="dynamicValidateForm.spec"></el-input>
          </el-col>
        </el-row>
      </el-form-item>
      <el-form-item
        label="库存"
        :rules="[{ required: true, message: '请输入商品库存', trigger: 'blur' }]">
        <el-row :gutter="20">
          <el-col :span="10">
            <el-input placeholder="请输入内容" prefix-icon="el-icon-edit-outline" v-model="dynamicValidateForm.stock"></el-input>
          </el-col>
        </el-row>
      </el-form-item>
      <el-form-item
          label="商品价格"
          :rules="[{ required: true, message: '价格不能为空'},{ type: 'number', message: '价格必须为数字值'}]">
          <el-row :gutter="20">
            <el-col :span="10">
              <el-input placeholder="请输入商品价格" prefix-icon="el-icon-edit-outline" type="text" v-model.number="dynamicValidateForm.price" auto-complete="off"></el-input>
            </el-col>
          </el-row>
        </el-form-item>
      <el-form-item>
          <el-button type="success" icon="el-icon-circle-plus" @click="submitForm('dynamicValidateForm')">提交</el-button>
          <el-button @click="resetForm('dynamicValidateForm')">重置</el-button>
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
        dynamicValidateForm: {
          name: '',
          spec:'',
          stock:'',
          price: '',
        }
      };
    },
    methods: {
      submitForm(formName) {
        this.$refs[formName].validate((valid) => {
          if(valid) {
            console.log(this.dynamicValidateForm);
            axios.post('/api/goods/add',{
              data:this.dynamicValidateForm
            })
            .then(response => {
                this.$router.push('/changku/index');
            })
          } else {
            console.log('error submit!!');
            return false;
          }
        });
      },
      resetForm(formName) {
        this.$refs[formName].resetFields();
      },
      removeDomain(item) {
        var index = this.dynamicValidateForm.domains.indexOf(item)
        if (index !== -1) {
          this.dynamicValidateForm.domains.splice(index, 1)
        }
      },
      handleChange(value) {
        console.log(value);
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

