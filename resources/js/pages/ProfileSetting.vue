<template>
    <div class="container">
        <div class="row justify-flex-center pb-4 border-bottom">
            <div class="col-md-5">
                <h2>
                    アバターアイコン
                </h2>
                <p>
                    ユーザーアイコンとしてプロフィールや投稿などに表示されます。
                </p>
            </div>
            <div class="col-md-7">
                <div class="card">
                    <div class="card-body">
                        <div class="col-4 mx-auto mb-2">
                            <avatar-icon 
                                :user="user"
                            />
                        
                        </div>
                        
                        <b-form-file>

                        </b-form-file>
                        <p>
                            1Mバイト以下の画像をアップロードすることができます。
                        </p>
                    </div>
                    <div class="card-footer">
                        <b-button variant="primary">保存</b-button>
                    </div>
                    
                </div>
            </div>

        </div>
    </div>
</template>
<script>
import AvatarIcon from '../atoms/AvatarIcon';
import SettingForm from '../templates/SettingForm';
import { mapState } from 'vuex';
export default {
    components: {
        AvatarIcon,
        SettingForm
    },

    computed: {
        ...mapState(['user'])
    }
}
</script>