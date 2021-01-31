<template>
    <div class="row">
        <!-- 検索候補 -->
        <div></div>

        <!-- 選択済みのタグ -->
        <div></div>
    </div>
</template>
<script>
export default {
    
    data() {
        return {
            tags: [],
            isLoading: false,
            form: {
                input: ''
            }
        }
    }
}
</script>