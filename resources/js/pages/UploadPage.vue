<template>
    <b-container class="bv-upload-page">
        <b-row>
            <b-col></b-col>
            <b-col cols="8">
                <b-form-group>
                    <b-form-radio-group
                            id="btn-radios-2"
                            v-model="form.device_type"
                            buttons
                            button-variant="outline-primary"
                            size="lg"
                            v-on:change="onReset"
                            name="radio-btn-outline">
                        <b-form-radio value="ios"><i class="fa fa-apple"></i>IOS</b-form-radio>
                        <b-form-radio value="android"><i class="fa fa-android"></i> ANDROID</b-form-radio>
                    </b-form-radio-group>
                </b-form-group>
                <b-form @submit="onSubmit" @reset="onReset" method="POST">
                    <b-form-group id="input-ios-1"
                                  label="Env"
                                  label-for="input-1"
                                  description="">
                        <b-form-select v-model="form.env"
                                       :options="options"
                                       name="env"
                                       v-validate="'required'"
                                       v-on:change="onChangeEnv">
                        </b-form-select>
                        <span v-show="errors.has('env')"
                              class="help is-danger text-danger">{{ errors.first('env') }}</span>
                    </b-form-group>
                    <b-form-group id="input-ios-2"
                                  label="App file"
                                  label-for="input-1"
                                  description="">
                        <b-form-file
                                v-model="form.app_file"
                                placeholder="Choose a file..."
                                drop-placeholder="Drop file here..."
                                accept=".ipa,.apk"
                                name="app_file"
                                v-validate="'required'"
                                v-on:change="onFileChange"
                        ></b-form-file>
                        <span v-show="errors.has('app_file')" class="help is-danger text-danger">{{ errors.first('app_file') }}</span>
                    </b-form-group>
                    <b-form-group
                            id="input-ios-3"
                            label="Version"
                            label-for="input-ios-version">
                        <b-form-input
                                id="input-ios-version"
                                v-model="form.version"
                                type="text"
                                placeholder="1.0.1"
                                v-validate="'required'"
                                name="version"
                        ></b-form-input>
                        <span v-show="errors.has('version')" class="help is-danger text-danger">{{ errors.first('version') }}</span>
                    </b-form-group>
                    <b-form-group
                            id="input-ios-4"
                            label="Build"
                            label-for="input-ios-build">
                        <b-form-input
                                id="input-ios-build"
                                v-model="form.build"
                                type="text"
                                placeholder="7"
                                name="build"
                                v-validate="'required'"
                        ></b-form-input>
                        <span v-show="errors.has('build')" class="help is-danger text-danger">{{ errors.first('build') }}</span>
                    </b-form-group>
                    <div class="processing-upload-container" v-if="loading">
                        <div class="progress progress-striped active">
                            <div :style="{width: this.percent + '%'}" aria-valuemax="100" aria-valuemin="0"
                                 aria-valuenow="40" role="progressbar" class="progress-bar progress-bar-danger">
                                <span class=""><span
                                        class="percent-text">{{this.percent}}</span>% Complete (success)</span>
                            </div>
                        </div>
                    </div>
                    <b-button variant="success" type="submit" :disabled="loading">
                        Submit
                        <i class="fa fa-spin fa-spinner" v-if="loading"></i>
                    </b-button>
                </b-form>
            </b-col>
            <b-col></b-col>
        </b-row>
    </b-container>
</template>

<script>

  import {success, error} from '../plugins/alert'

  export default {
    data() {
      return {
        form: {
          device_type: 'ios',
          env: null,
          app_file: null,
          version: null,
          build: null
        },
        show: true,
        loading: false,
        percent: 0,
        options: [
          {value: null, text: 'Please select env'},
          {value: 'dev', text: 'DEV'},
          {value: 'stg', text: 'STG'},
          {value: 'prod', text: 'PROD'}
        ]
      }
    },
    methods: {
      onChangeType(type) {
        this.form.device_type = type
        this.onReset()
      },
      onChangeEnv() {
        let params = {
          env: this.form.env,
          device_type: this.form.device_type
        }
        this.$http.get('latest-version', {params: params})
          .then((res) => {
            if (res.status === 200) {
              this.form.build = res.data.data.build
              this.form.version = res.data.data.version
            }
          })
      },
      onFileChange(e) {
        let files = e.target.files || e.dataTransfer.files
        if (!files.length)
          return
        this.form.app_file = files[0]
      },
      createImage(file) {
        let reader = new FileReader()
        let vm = this
        reader.onload = (e) => {
          vm.form.app_file = e.target.result
        };
        reader.readAsDataURL(file)
      },
      onSubmit(evt) {
        evt.preventDefault()
        this.$validator.validate().then(valid => {
          if (valid) {
            this.loading = true
            let formData = new FormData()
            _.map(this.form, (item, key) => {
              formData.append(key, item)
            })
            this.$http.post('upload', formData, {
              headers: {
                'Content-Type': 'multipart/form-data'
              },
              onUploadProgress: (progressEvent) => {
                if (progressEvent.lengthComputable) {
                  this.percent = Math.round((progressEvent.loaded / progressEvent.total) * 100)
                }
              }
            })
              .then((res) => {
                this.loading = false
                if (res.data.status) {
                  success('Uploaded successfully!!!')
                  this.errors.clear()
                  this.$router.push('downloads')
                } else {
                  error('Error happen, please reload page and try again')
                }
              }).catch((err) => {
              this.loading = false
              console.log(err)
              error('Opps!!! Error')
            })
          }
        });
      },
      onReset() {
        // Reset our form values
        this.errors.clear()
        this.form.env = null
        this.form.app_file = null
        this.form.version = null
        this.form.build = null
        // Trick to reset/clear native browser form validation state
        this.show = false
        this.loading = false
      }
    }
  }
</script>
