<template>
  <el-upload
    class="avatar-uploader text-center"
    action="https://jsonplaceholder.typicode.com/posts/"
    :on-success="handleAvatarSuccess"
    :before-upload="beforeAvatarUpload"
    :show-file-list="false"
    :multiple="false"
    :on-error="handleError"
    :http-request="uploadProfilePicture"
    :auto-upload="true"
    accept=" .jpg, .jpeg, .png, .bmp, .svg"
  >
    <img v-if="imageUrl" :src="imageUrl" class="avatar">
    <i v-else class="el-icon-plus avatar-uploader-icon" />
  </el-upload>
</template>

<script>
import { POST } from '../../plugins/axios.js'
import { USER_PHOTO_UPLOAD } from '../../const/api.js'
export default {
  data () {
    return {
      imageUrl: ''
    }
  },
  computed: {
    userGetters () {
      return this.$store.getters.user
    }
  },
  created () {
    this.bootstrapping()
  },
  methods: {
    bootstrapping () {
      this.imageUrl = this.userGetters.userInfo.photo ? this.userGetters.userInfo.photo : '../../assets/user.png'
    },
    handleAvatarSuccess () {
      this.$message({
        message: 'Successfully Updated',
        type: 'success'
      })
    },
    handleError () {
      this.$message({
        message: 'Something Went Wrong When Uploading!!',
        type: 'error'
      })
    },
    async uploadProfilePicture () {
      let data = new FormData()
      data.append('photo', this.file)
      data.append('path', 'user')
      let res = await POST(USER_PHOTO_UPLOAD, data)
      this.imageUrl = res.data.photo
    },
    beforeAvatarUpload (file) {
      const isJPG = file.type === 'image/jpeg'
      const isLt2M = file.size / 1024 / 1024 < 2

      if (!isJPG) {
        this.$message.error('Avatar picture must be JPG format!')
      }
      if (!isLt2M) {
        this.$message.error('Avatar picture size can not exceed 2MB!')
      }
      return isJPG && isLt2M
    }
  }
}
</script>

<style>
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
</style>
