<template>
    <div class="container">
        <setting-form-layout>
            <template v-slot:header>
                <h2>
                    アバターアイコン
                </h2>
                <p>
                    ユーザーアイコンとしてプロフィールや投稿などに表示されます。
                </p>
            </template>
            <template v-slot:body>
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
            </template>
            <template v-slot:footer >
                <div class="text-right">
                    <b-button class="ml-2">削除</b-button>
                    <b-button variant="primary">アップロード</b-button>

                </div>

            </template>
        </setting-form-layout>
        <setting-form-layout class="mt-4">
            <template v-slot:header>
                <h2>
                    ユーザー名
                </h2>
                <p>
                    投稿やプロフィールに表示されます。<br>
                    一意である必要があります。
                </p>
            </template>
            <template v-slot:body>
                <b-form-input
                    placeholder="ユーザー名"
                    v-model="user_name"
                />
            </template>
            
        </setting-form-layout>
        
    </div>
</template>
<script>
import AvatarIcon from '../atoms/AvatarIcon';
import SettingFormLayout from '../templates/SettingFormLayout';
import { mapState } from 'vuex';
export default {
    components: {
        AvatarIcon,
        SettingFormLayout
    },

    computed: {
        ...mapState(['user'])
    },
    data(){
        return {
            avatar_icon_file: null,
            user_name: this.$store.state.user.user_name,

        };
    }
}
</script>