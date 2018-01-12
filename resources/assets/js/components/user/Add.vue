<template>
  <div class="spread con">
    <el-breadcrumb separator-class="el-icon-arrow-right">
      <el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
      <el-breadcrumb-item>添加员工</el-breadcrumb-item>
    </el-breadcrumb>
    <el-form :model="dynamicValidateForm" ref="dynamicValidateForm" label-width="100px" class="demo-dynamic">
      <el-form-item
        label="直接上级"
        :rules="[{ required: true, message: '请输入上级', trigger: 'blur' }]">
        <el-row :gutter="20">
          <el-col :span="10">
            <el-select v-model="dynamicValidateForm.super_id" filterable placeholder="请选择">
                <el-option
                  v-for="item in userData"
                  :key="item.id"
                  :label="item.username"
                  :value="item.id">
                </el-option>
            </el-select>
          </el-col>
        </el-row>
      </el-form-item>
      <el-form-item
        label="用户头像">
        <el-row :gutter="20">
          <el-col :span="10">
            <el-upload
              class="avatar-uploader"
              action="/api/upload"
              :data="{'_token':token}"
              :show-file-list="false"
              :on-success="handleAvatarSuccess"
              :before-upload="beforeAvatarUpload">
              <img v-if="imageUrl" :src="imageUrl" class="avatar">
              <i v-else class="el-icon-plus avatar-uploader-icon"></i>
            </el-upload>
          </el-col>
        </el-row>
      </el-form-item>
      <el-form-item
        label="用户职位"
        :rules="[{ required: true, message: '请输入用户名称', trigger: 'blur' }]">
        <el-row :gutter="20">
          <el-col :span="10">
            <el-radio-group v-model="dynamicValidateForm.status" size="medium">
                <el-radio-button label="0">普通员工</el-radio-button>
                <el-radio-button label="1">组长/仓库级</el-radio-button>
                <el-radio-button label="2">经理级</el-radio-button>
                <el-radio-button label="3">最高级</el-radio-button>
            </el-radio-group>
          </el-col>
        </el-row>
      </el-form-item>
      <el-form-item
        label="用户名称"
        :rules="[{ required: true, message: '请输入用户名称', trigger: 'blur' }]">
        <el-row :gutter="20">
          <el-col :span="10">
            <el-input placeholder="请输入用户名称" prefix-icon="el-icon-edit-outline" v-model="dynamicValidateForm.username"></el-input>
          </el-col>
        </el-row>
      </el-form-item>
      <el-form-item
        label="用户密码"
        :rules="[{ required: true, message: '请输入用户密码', trigger: 'blur' }]">
        <el-row :gutter="20">
          <el-col :span="10">
            <el-input placeholder="请输入用户密码" type="password" prefix-icon="el-icon-edit-outline" v-model="dynamicValidateForm.password"></el-input>
          </el-col>
        </el-row>
      </el-form-item>
      <el-form-item
        label="确定密码"
        :rules="[{ required: true, message: '请输入用户密码', trigger: 'blur' }]">
        <el-row :gutter="20">
          <el-col :span="10">
            <el-input placeholder="请输入用户密码" type="password" prefix-icon="el-icon-edit-outline" v-model="dynamicValidateForm.cpassword"></el-input>
          </el-col>
        </el-row>
      </el-form-item>
      <el-form-item>
          <el-button type="primary" @click="submitForm('dynamicValidateForm')">提交</el-button>
          <el-button @click="resetForm('dynamicValidateForm')">重置</el-button>
      </el-form-item>
    </el-form>
  </div>
</template>

<script>
export default {
    data() {
        return {
            imageUrl: '',
            token:'',
            userData:[],
            dynamicValidateForm: {
                username: '',
                password: '',
                cpassword: '',
                super_id:'',
                status:"0"
            }
        };
    },
    created(){
        this.token = window.axios.defaults.headers.common['X-CSRF-TOKEN'];
        this.getUser()
    },
    methods: {
        submitForm(formName) {
            if(this.dynamicValidateForm.password == this.dynamicValidateForm.cpassword){
                axios.post('/api/user/add',{
                    data:{
                        username:this.dynamicValidateForm.username,
                        password:this.dynamicValidateForm.password,
                        super_id:this.dynamicValidateForm.super_id,
                        status:this.dynamicValidateForm.status,
                    }
                })
                .then(response => {
                    if(response.data.result.id){
                        this.$message.success('账号添加成功');
                        this.$router.push('/user');
                    }else{
                        this.$message.error('账号添加失败');
                    }
                })
            }else{
                this.$message.error('两次密码输入不一致');
            }
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
        },
        getUser(){
            axios.get('/api/user?status=1')
                .then(res => {
                    this.userData = res.data.result
                })
        },
        handleAvatarSuccess(res, file) {
          this.imageUrl = URL.createObjectURL(file.raw);
        },
        beforeAvatarUpload(file) {
          const isJPG = file.type === 'image/jpeg';
          const isLt2M = file.size / 1024 / 1024 < 2;

          if (!isJPG) {
            this.$message.error('上传头像图片只能是 JPG 格式!');
          }
          if (!isLt2M) {
            this.$message.error('上传头像图片大小不能超过 2MB!');
          }
          return isJPG && isLt2M;
        }
    }
}
</script>

<style type="text/css" lang="scss">
  .con{
    .el-breadcrumb{
      height: 40px;
    }
    .avatar-uploader .el-upload {
      border: 1px dashed #d9d9d9;
      border-radius: 6px;
      cursor: pointer;
      position: relative;
      overflow: hidden;
    }
    .avatar-uploader .el-upload:hover {
      border-color: #409EFF;
    }
    .avatar-uploader-icon {
      font-size: 28px;
      color: #8c939d;
      width: 178px;
      height: 178px;
      line-height: 178px;
      text-align: center;
    }
    .avatar {
      width: 178px;
      height: 178px;
      display: block;
    }
    
    .avatar-uploader .el-upload__input{
      display: none;
    }
  }
</style>

