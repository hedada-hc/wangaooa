<template lang="html">
    <el-container>
        <el-header>
            <div class="title">
              <i class="el-icon-location"></i>我爱推管理系统
            </div>
            <el-menu
              :default-active="activeIndex2"
              class="el-menu-demo"
              mode="horizontal"
              @select="handleSelect"
              background-color="#ff5000"
              text-color="#fff"
              :router="true"
              active-text-color="#f3f900">
              <el-menu-item index="/order">我的办公室</el-menu-item>
              <el-menu-item v-if="auth.alc.cates > 0" index="/changku">仓库管理</el-menu-item>
              <el-menu-item v-if="auth.alc.user > 0" index="/user">员工管理</el-menu-item>
              <el-menu-item index="/count">数据分析</el-menu-item>
            </el-menu>
            <div class="logout">
                <p>欢迎你，{{auth.username}}<a style="cursor:pointer;" @click="logout">退出</a></p>
            </div>
        </el-header>
        <el-container>
            <router-view :user="user" class="main_con"></router-view>
        </el-container>
        
    </el-container>
</template>

<script>
    export default {
        props:['user'],
        data(){
            return {
                activeIndex: '1',
                activeIndex2: '1',
                auth:{alc:{}}
            }
        },
        mounted() {
            this.isLogin();
        },
        methods:{
            logout() {
              this.$message({
                    showClose: true,
                    message: '退出成功',
                    type: 'success'
                });
                axios({
                  url:'/logout',
                  method:'post',
                })
                .then(response => {
                  this.util.renderLogin();
                })
                .catch(error => {
                  this.$message({
                      showClose: true,
                      message: '退出失败',
                      type: 'success'
                  });
                })

            },
            handleSelect(key, keyPath) {
                console.log(key, keyPath);
            },
            handleOpen(key, keyPath) {
                console.log(key, keyPath);
            },
            handleClose(key, keyPath) {
                console.log(key, keyPath);
            },
            isLogin(){
              if(!this.user){
                this.$router.push("/login");
              }else{
                this.auth = JSON.parse(this.user);
                console.log(this.auth)
              }
            }
        }
    }
</script>

<style type="text/css" lang="scss">
    .el-header{
        padding: 0px;
        background-color: rgb(255, 80, 0);
        .title{
          position: fixed;
          z-index: 100;
          width: 188px;
          height: 61px;
          text-align: center;
          line-height: 61px;
          color: #ffffff;
          font-size:16px;
        }
        .el-menu--horizontal{
          width: 80%;
          border-right: none;
          border-bottom: solid 1px #e6e6e6;
          margin-left: 188px;
        }
        .logout{
          width: 210px;
          position: fixed;
          z-index: 100;
          right: 1px;
          top: 0px;
          p{
            color: #ffffff;
            line-height: 61px;
            a{
              padding-left:10px;
              color: #ffffff;
            }
          }
        }
    }

    .main_con{
      width: 100%;
      .el-aside{
        width: 10%;
        border-right: solid 1px #e6e6e6;
        list-style: none;
        position: relative;
        margin: 0;
        padding-left: 0;
      }
      .el-main{
        padding: 15px 20px 15px 15px;
        width: 89%;
        height: 100%;
        float: left;

      }
    }
</style>
