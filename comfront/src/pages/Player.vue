<template>
<q-page class="q-pa-xs">
<div class="row">
  <div class="col-12">
    <q-table title="Jugadores" :columns="columnsplayers" :rows="players" :filter="filterplayer">
      <template v-slot:top-right>
        <q-btn label="Crear jugador" icon="add_circle" color="positive" @click="frmplayer" />
        <q-input outlined dense debounce="300" v-model="filterplayer" placeholder="Buscar">
          <template v-slot:append>
            <q-icon name="search" />
          </template>
        </q-input>
      </template>
      <template v-slot:body-cell-Opciones="props">
        <q-td :props="props">
          <q-btn-dropdown color="primary" label="Opciones">
            <q-list>
              <q-item clickable v-close-popup @click="dialogupdateplayer=true;player=props.row">
                <q-item-section>
                  <q-item-label>Modificar jugador</q-item-label>
                </q-item-section>
              </q-item>
              <q-item clickable v-close-popup @click="frmeliminar(props.row)">
                <q-item-section>
                  <q-item-label>Eliminar jugador</q-item-label>
                </q-item-section>
              </q-item>
            </q-list>
          </q-btn-dropdown>
        </q-td>
      </template>
    </q-table>
    <q-dialog v-model="dialogupdateplayer" full-width full-height>
      <q-card>
        <q-card-section class="text-h6">
          Modificador jugador
        </q-card-section>
        <q-separator/>
        <q-card-section class="text-h6">
          <q-form @submit="updateplayer">
            <div class="row">
              <div class="col-6">
                <q-input outlined style="text-transform: uppercase" dense label="paterno" v-model="player.paterno"/>
              </div>
              <div class="col-6">
                <q-input outlined style="text-transform: uppercase" dense label="materno" v-model="player.materno"/>
              </div>
              <div class="col-6">
                <q-input outlined style="text-transform: uppercase" dense label="nombres" v-model="player.nombres"/>
              </div>
              <div class="col-6">
                <q-input outlined style="text-transform: uppercase" dense label="ci" v-model="player.ci"/>
              </div>
              <div class="col-6">
                <q-input type="date" outlined dense label="fechanac" v-model="player.fechanac"/>
              </div>
              <div class="col-12">
                <q-btn type="submit" label="Modificar" class="full-width" icon="edit" color="positive" />
              </div>
            </div>
          </q-form>
        </q-card-section>
      </q-card>
    </q-dialog>
    <q-dialog v-model="dialogcreateplayer" full-width full-height>
      <q-card>
        <q-card-section class="text-h6">
          Crear jugador
        </q-card-section>
        <q-separator/>
        <q-card-section class="text-h6">
          <q-form @submit="createplayer">
            <div class="row">
              <div class="col-6">
                <q-input outlined style="text-transform: uppercase" dense label="paterno" v-model="player.paterno"/>
              </div>
              <div class="col-6">
                <q-input outlined style="text-transform: uppercase" dense label="materno" v-model="player.materno"/>
              </div>
              <div class="col-6">
                <q-input outlined style="text-transform: uppercase" dense label="nombres" v-model="player.nombres"/>
              </div>
              <div class="col-6">
                <q-input outlined style="text-transform: uppercase" dense label="ci" v-model="player.ci"/>
              </div>
              <div class="col-6">
                <q-input type="date" outlined dense label="fechanac" v-model="player.fechanac"/>
              </div>
              <div class="col-12">
                <q-btn type="submit" label="Crear" class="full-width" icon="add_circle" color="positive" />
              </div>
            </div>
          </q-form>
        </q-card-section>
      </q-card>
    </q-dialog>
  </div>
</div>
</q-page>
</template>
<script>
import {date} from 'quasar'
import moment from 'moment'
export default {
  name: `Player`,
  data(){
    return {
      filterplayer:'',
      dialogcreateplayer:false,
      dialogupdateplayer:false,
      players:[],
      player:{},
      columnsplayers:[
        {name:"Opciones",label:"Opciones",field:"Opciones",align: 'center'},
        {name:"nombrecompleto",label:"nombrecompleto",field:"nombrecompleto",align:'left'},
        {name:"edad",label:"edad",field:"edad",align:'left'},
      ]
    }
  },
  created() {
    this.misplayes()
  },
  methods:{
    frmplayer(){
      this.dialogcreateplayer=true;
      this.player.fechanac=date.formatDate(new Date(),'YYYY-MM-DD')
    },
    misplayes(){
      this.$q.loading.show()
      this.$api.get('player').then(res=>{
        // console.log(res.data)
        this.$q.loading.hide()
        // return false
        this.players=[]
        res.data.forEach(r=>{
          let d=r
          let nacimiento=moment(r.fechanac);
          let hoy=moment();
          let anios=hoy.diff(nacimiento,"years");
          d.nombrecompleto=r.paterno+' '+r.materno+' '+r.nombres
          d.edad=anios
          this.players.push(d)
        })

      })
    },
    updateplayer(){
      this.$q.loading.show()
      // console.log(this.player)
      this.player.paterno=this.player.paterno.toUpperCase()
      this.player.materno=this.player.materno.toUpperCase()
      this.player.nombres=this.player.nombres.toUpperCase()
      this.$api.put('player/'+this.player.id,this.player).then(res=>{
        this.misplayes()
        this.dialogupdateplayer=false
      })
    },
    frmeliminar(p){
      this.$q.dialog({
        title:'Eliminar?',
        message:'Seguro de Eliminar?',
        cancel:true,
      }).onOk(()=>{
        this.$q.loading.show()
        this.$api.delete('player/'+p.id).then(res=>{
          // console.log()
          this.misplayes()
        })
      })
    },
    createplayer(){
      this.$q.loading.show()
      this.player.paterno=this.player.paterno.toUpperCase()
      this.player.materno=this.player.materno.toUpperCase()
      this.player.nombres=this.player.nombres.toUpperCase()
      this.player.ci=this.player.ci.toUpperCase()
      // console.log(this.player)
      this.$api.post('player',this.player).then(res=>{
        this.misplayes()
        this.dialogcreateplayer=false
      })
    },
  }
}
</script>

<style scoped>

</style>
