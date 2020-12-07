import Vue from 'vue';

export default {

    namespaced: true,

    state(){
        return {
            notes: {},

        }
    },

    actions: {

    },

    getters: {
        getNotesByIds:(state) => (ids)=>{
            console.assert(Array.isArray(ids), "idsは配列である必要があります。");
            return ids.map((id)=> state.notes[id]);
        },
        getNoteById:(state) => (id)=>{
            return state.notes[id];
        }
    }
}