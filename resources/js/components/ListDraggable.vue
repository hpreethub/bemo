<template>
<div>

        <draggable :list="cardsData" :options="{animation:250, handle:'.move', group:'colid'}" :element="'ul'"
                   class="list-group min-height" @change="update" @add="e=>onAdd(e, colid)" >
            <li class="list-group-item d-flex justify-content-between" v-for="(card,index) in cardsData" :data-id="card.id" :key="card.id" :data-order="card.order">
                <span @click="e=>updateEditModal(e)" data-toggle="modal" data-target="#editCard" :data-id="card.id" :data-title="card.title" :data-description="card.description">{{card.title}}</span>
                <span><i class="fas fa-arrows-alt move"></i></span>
            </li>
        </draggable>


</div>
</template>

<script>
import draggable from 'vuedraggable';
    export default {
        components:{
            draggable
        },
        props:['cards','colid'],
        mounted() {
            // axios.get()
        },
        data(){
           return{
               colId:'',
               cardsData :this.cards,
               csrf: document.head.querySelector('meta[name=csrf-token]').content,

           }
       },
    methods:{
        addCard:function(e,id){
            this.colId = id;
        },
        onAdd:function(event,column){
            let id = event.item.getAttribute('data-id');
            let order = event.item.getAttribute('data-order');
            console.log(event.item);
            console.log("col-id:",column);
            console.log("card-id:",id);
            axios.put('/card/move/'+id,{column:column,order:order});
        },

        update:function (){
            this.cardsData.map((card,index)=>{card.order = index+1;})
            axios.put('/card/sort',{
                cardsData : this.cardsData,
                csrf: document.head.querySelector('meta[name=csrf-token]').content
            })
        },

    }
    }
</script>
