<template>
    <div>
        <div>
            <h3>ユーザーを探す</h3>
            <p>ユーザーが利用しているタグをもとにユーザーを探してみましょう。</p>
        </div>
        <div>
            <search-tag />
        </div>
    </div>
</template>
<script>
import SearchTag from './SearchTag';

export default {
    components: {
        SearchTag
    }
}
</script>