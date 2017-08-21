import {UploaderBuilder} from './../upload/qiniu4js.js';
import {View} from 'zjs/base/View.js';
// import {request} from 'zjs/http/request';

class Upload extends View {
    render() {
        this.ctn.innerHTML = this.tpl`
            ${this.trans('uploadImg')}
            <ul class="img-preview">
                <a href="javascript:;" class="btn-upload"><i class="icon icon-add-one"></i></a>
            </ul>
        `;
    }

    startup() {
        if (!Array.isArray(this.data)) {
            this.data = [];
        }
        let that = this;

        // 更多配置，参考https://github.com/lsxiao/qiniu4js
        let uploader  = new UploaderBuilder()
            .debug(false)//开启debug，默认false
            // .button('uploadButton')//指定上传按钮
            .retry(0)//设置重传次数，默认0，不重传
            .auto(true)//选中文件后立即上传，默认true
            .multiple(true)//是否支持多文件选中，默认true
            .accept(['.gif', '.png', '.jpg', '.jpeg', 'webp', 'bmp', 'video/*'])//过滤文件，默认无，详细配置见http://www.w3schools.com/tags/att_input_accept.asp
            .tokenShare(true)
            // 设置token获取URL：客户端向该地址发送HTTP GET请求, 若成功，服务器端返回{"uptoken": 'i-am-token'}。
            .tokenUrl(this.pageAttr('fetchUpToken'))
            .listener({
                onReady() {
                    //该回调函数在图片处理前执行,也就是说task.file中的图片都是没有处理过的
                    //选择上传文件确定后,该生命周期函数会被回调。
                },
                onStart(){
                    //所有内部图片任务处理后执行
                    //开始上传
                },
                onTaskGetKey(){
                    //为每一个上传的文件指定key,如果不指定则由七牛服务器自行处理
                    return Date.now() + '-' + Math.floor(Math.random()*10000+1);
                },
                onTaskProgress: function () {
                    //每一个任务的上传进度,通过`task.progress`获取
                },
                onTaskSuccess(task) {
                    //一个任务上传成功后回调
                    that.appendImg(task.result.key);
                    that.setKeys(task.result.key);
                },
                onTaskFail() {
                    //一个任务在经历重传后依然失败后回调此函数
                },
                onTaskRetry() {
                    //开始重传
                },
                onFinish(){
                    //所有任务结束后回调，注意，结束不等于都成功，该函数会在所有HTTP上传请求响应后回调(包括重传请求)。
                }
            })
            .build();

        //你可以自行监听HTML元素的click事件，在回调函数内部打开文件选择窗口
        this.ctn.elem('.btn-upload').addEventListener("click", function () {
            uploader.chooseFile();
        });

        this.ctn.elem('.img-preview').on('click', (e) => {
            if (e.target.hasClass('icon-delete')) {
                let key = e.target.getAttribute('data-key');
                // request.postJson(this.pageAttr('deleteQiniuResource'), {key: key})
                //     .then(data => {
                //         if (data.result == null) {
                //             this.removeKeys(key);
                //             e.target.parentNode.parentNode.remove();
                //         }
                //     });
                this.removeKeys(key);
                e.target.parentNode.parentNode.remove();
            }
        });
    }

    getKeys() {
        return this.data;
    }

    setKeys(key) {
        this.data.push(key);
    }

    removeKeys(key) {
        for(let i=0; i<this.data.length; i++) {
            if(this.data[i] == key) {
                this.data.splice(i, 1);
                break;
            }
        }
    }

    clearImg() {
        this.data = [];
        this.ctn.s('li').forEach((elem) => elem.remove());
    }

    appendImg(key) {
        let imgPreview = document.createElement('li');
        imgPreview.addClass('inline img-item');
        imgPreview.innerHTML = this.tpl`
            <img src="${this.pageAttr('qiniuDomain') + key + '?imageMogr2/thumbnail/80x/strip/quality/50/format/jpg'}"/>
            <div class="btn-img">
                <i class="icon icon-delete cursor" data-key="${key}"></i>
            </div>
        `;
        this.ctn.elem('.img-preview').appendChild(imgPreview);
    }
}

export {Upload};
