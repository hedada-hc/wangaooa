<template>
  <div class="spread con">
    <el-breadcrumb separator-class="el-icon-arrow-right">
      <el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
      <el-breadcrumb-item>权限管理</el-breadcrumb-item>
    </el-breadcrumb>
    <el-form :model="alcDataForm" ref="alcDataForm" label-width="100px" class="demo-dynamic">
        <el-form-item
            label="订单权限"
            :rules="[{ required: true, message: '请输入订单权限设置', trigger: 'blur' }]">
            <el-row :gutter="20">
              <el-col :span="10">
                    <el-transfer
                        :titles="['权限列表','已有权限']"
                        v-model="alcDataForm.alcSelectList"
                        :props="{
                          key: 'value',
                          label: 'desc'
                        }"
                        :data="alcDataForm.alcList">
                    </el-transfer>
              </el-col>
            </el-row>
        </el-form-item>
        <el-form-item
            label="商品权限"
            :rules="[{ required: true, message: '请输入用户名称', trigger: 'blur' }]">
            <el-row :gutter="20">
              <el-col :span="10">
                <el-radio-group v-model="alcDataForm.goods.status" size="medium">
                    <el-radio-button label="0">无权限</el-radio-button>
                    <el-radio-button label="1">新增权限</el-radio-button>
                    <el-radio-button label="2">删除权限</el-radio-button>
                    <el-radio-button label="3">增删改查权限</el-radio-button>
                </el-radio-group>
              </el-col>
            </el-row>
        </el-form-item>
        <el-form-item
            label="仓库权限"
            :rules="[{ required: true, message: '请输入用户名称', trigger: 'blur' }]">
            <el-row :gutter="20">
              <el-col :span="10">
                <el-radio-group v-model="alcDataForm.cateGoods.status" size="medium">
                    <el-radio-button label="0">无权限</el-radio-button>
                    <el-radio-button label="1">新增权限</el-radio-button>
                    <el-radio-button label="2">删除权限</el-radio-button>
                    <el-radio-button label="3">增删改查权限</el-radio-button>
                </el-radio-group>
              </el-col>
            </el-row>
        </el-form-item>
        <el-form-item
            label="用户权限"
            :rules="[{ required: true, message: '请输入用户名称', trigger: 'blur' }]">
            <el-row :gutter="20">
              <el-col :span="10">
                <el-radio-group v-model="alcDataForm.user.status" size="medium">
                    <el-radio-button label="0">无权限</el-radio-button>
                    <el-radio-button label="1">新增权限</el-radio-button>
                    <el-radio-button label="2">删除权限</el-radio-button>
                    <el-radio-button label="3">增删改查权限</el-radio-button>
                </el-radio-group>
              </el-col>
            </el-row>
        </el-form-item>
      <el-form-item>
          <el-button type="primary" @click="submitForm('alcDataForm')">提交</el-button>
      </el-form-item>
    </el-form>
  </div>
</template>

<script>
export default {
    data() {
        const generateData3 = _ => {
            const data = [];
            for (let i = 1; i <= 15; i++) {
              data.push({
                value: i,
                desc: `备选项 ${ i }`,
                disabled: i % 4 === 0
              });
            }
            return data;
        };
        return {
            userAlc:{},
            alcDataForm: {
                user_id:'',
                user:{status:0},
                goods:{status:0},
                cateGoods:{status:0},
                alcList: generateData3(),
                alcSelectList: [],
            }
        };
    },
    created(){
        if(!this.$route.params.id){
            this.$message.error("请重正确地址进入本页面")
            this.$router.push('/user');
        }
        this.getUser()
        this.alcDataForm.user_id = this.$route.params.id
    },
    methods: {
        submitForm(formName) {
            console.log(this.alcDataForm.alcSelectList)
            axios.post('/api/user/add/alc',{
                user_id:this.alcDataForm.user_id,
                order:this.alcDataForm.alcSelectList,
                user:this.alcDataForm.user.status,
                goods:this.alcDataForm.goods.status,
                cateGoods:this.alcDataForm.cateGoods.status,
            })
                .then(res => {

                })
                .catch(erro => {

                })
        },
        resetForm(formName) {
            this.$refs[formName].resetFields();
        },
        handleChange(value) {
            console.log(value);
        },
        getUser(){
            axios.get('/api/user/alc/list?id='+this.$route.params.id)
                .then(res => {
                    this.alcDataForm.alcList = res.data.result.order;
                    this.alcDataForm.alcSelectList = JSON.parse(res.data.result.alc.order);
                    this.alcDataForm.goods.status = res.data.result.alc.goods;
                    this.alcDataForm.cateGoods.status = res.data.result.alc.cates;
                    this.alcDataForm.user.status = res.data.result.alc.user;

                    //this.handleAlcList();
                })
                .catch(err => {

                })
        },
        handleAlcList(){
            let tmpArr = []
            for(let i in this.alcDataForm.alcList){
                if(this.alcDataForm.alcSelectList.indexOf(this.alcDataForm.alcList[i].value) <= -1){
                    tmpArr.push({
                        value:this.alcDataForm.alcList[i].value,
                        desc:this.alcDataForm.alcList[i].desc
                    });
                }
            }
            this.alcDataForm.alcList = tmpArr;
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

