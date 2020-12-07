import Vue from 'vue';
import axios from 'axios';

export default {

    namespaced: false,

    state(){
        return {
            notes: {},

        }
    },

    mutations: {
        setNotes(state, notes){
            console.assert(Array.isArray(notes), "notesは配列である必要があります");
            for(let i = 0; i < notes.length; i ++ ){
                let note = notes[i];
                Vue.set(this.notes, new String(note.id), note);
            }
        },
        setNote(state, note){
            Vue.set(this.notes, new String(note.id), note);
        }
    },

    actions: {
        favorite(state, getters, rootState){
            // TODO 実装する
        },
        unfavorite(state, getters, rootState){
            // TODO 実装する
        }
    },

    getters: {
        getNotesByIds:(state) => (ids)=>{
            console.assert(Array.isArray(ids), "idsは配列である必要があります。");
            return ids.map((id)=> state.notes[new String(id)]);
        },
        getNoteById:(state) => (id)=>{
            return state.notes[new String(id)];
        }
    }
}