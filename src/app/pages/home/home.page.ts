import { Component, OnInit } from '@angular/core';
import { Router, ActivatedRoute, NavigationExtras, ParamMap } from '@angular/router';
import { ToastController, LoadingController, AlertController, NavController } from "@ionic/angular";
import { AccessProviders } from "../../providers/access-providers";
import { Storage } from "@ionic/storage";
import { Network } from "@ionic-native/network/ngx";
import { Dialogs } from "@ionic-native/dialogs/ngx";
import { ScreenOrientation } from '@ionic-native/screen-orientation/ngx';

@Component({
  selector: 'app-home',
  templateUrl: './home.page.html',
  styleUrls: ['./home.page.scss'],
})
export class HomePage implements OnInit {

  datastorage: any;
  judge_id;

  round_id;
  school_id_1;
  school_name_1;
  school_id_2;
  school_name_2;

  school_1;
  school_2;

  school_judge_id_1;
  school_judge_id_2;

  connection_status: Boolean = true;

  constructor(
    private router: Router,
    private activatedRoute: ActivatedRoute,
    private toastCtrl: ToastController,
    private loadingCtrl: LoadingController,
    private alertCtrl: AlertController,
    private navCtrl: NavController,
    private accsPrvds: AccessProviders,
    private storage: Storage,
    public network: Network,
    private dialog: Dialogs,
    private screenOrientation: ScreenOrientation
  ) {
    this.network.onDisconnect().subscribe(() => {
      this.connection_status = false;
    });

    this.network.onConnect().subscribe(() => {
      this.connection_status = true;
    });

    // set screen orientation to portrait
    this.screenOrientation.lock(this.screenOrientation.ORIENTATIONS.PORTRAIT);
   }

  ngOnInit() {
  }

  ionViewDidEnter() {
    this.storage.get('storage_xxx').then((res)=>{
      console.log(res);
      this.datastorage = res;
      this.judge_id = this.datastorage.judge_id;
      this.loadStudents();
    });
  }

  async doRefresh(event) {
    setTimeout(() => {
      this.ionViewDidEnter();
      event.target.complete();
    });
  }

  async loadStudents() {
    this.round_id = null;
    this.school_id_1 = "";
    this.school_name_1 = "";
    this.school_id_2 = "";
    this.school_name_2 = "";
    this.school_judge_id_1 = "";
    this.school_judge_id_2 = "";
    this.school_1 = [];
    this.school_2 = [];

    const loader = await this.loadingCtrl.create({
      message: 'Please wait...',
    });
    loader.present();

    return new Promise(resolve=> {
      let body = {
        aksi: 'load_schools_students',
        judge_id: this.judge_id
      }

      this.accsPrvds.postData(body, 'process_api.php').subscribe((res:any)=>{
        if (res.result.length > 0) {
          this.round_id = res.result[0]['round_id'];
          this.school_id_1 = res.result[0]['school_id'];
          this.school_name_1 = res.result[0]['school_name'];
          this.school_id_2 = res.result[res.result.length - 1]['school_id'];
          this.school_name_2 = res.result[res.result.length - 1]['school_name'];
          this.school_judge_id_1 = res.result[0]['school_judge_id'];
          this.school_judge_id_2 = res.result[res.result.length - 1]['school_judge_id'];

          for (let datas of res.result) {
            if (datas['school_id'] == this.school_id_1) {
              this.school_1.push(datas);
            }
            else if (datas['school_id'] == this.school_id_2)
              this.school_2.push(datas);
          }

          this.school_1.push({'round_id':this.round_id, 'school_id':this.school_id_1, 'school_name':this.school_name_1, 'student_id':'#overall', 'student_name':'Overall'});
          this.school_2.push({'round_id':this.round_id, 'school_id':this.school_id_2, 'school_name':this.school_name_2, 'student_id':'#overall', 'student_name':'Overall'});

          loader.dismiss();
        }
        else {
          this.round_id = "";
          loader.dismiss();
          this.presentToast('Currently no records found!');
        }

        resolve(true);

      },(err)=>{
        loader.dismiss();
        this.presentToast('Unable to load data!');
      })
    });
  }

  openStudentScores(round_id, school_id, school_name, student_id, student_name) {
    let navigationExtras: NavigationExtras = {
      queryParams: {
          round_id : round_id,
          school_id : school_id,
          school_name : school_name,
          student_id : student_id,
          student_name : student_name
      }
    };
    this.navCtrl.navigateForward(['/scores'], navigationExtras);
  }

  async presentToast(a) {
    const toast = await this.toastCtrl.create({
      message: a,
      duration: 1500,
      position: 'bottom'
    });
    toast.present();
  }

  isStudentEvaluated(school_id, student_id, student_judge_id) {
    if (student_judge_id != null && student_id != '#overall') {
      return true;
    }
    else if (this.school_judge_id_1 != null && school_id == this.school_id_1 && student_id == '#overall') {
      return true;
    }
    else if (this.school_judge_id_2 != null && school_id == this.school_id_2 && student_id == '#overall') {
      return true;
    }
    else {
      return false;
    }
  }
  
  async processLogout() {
    this.storage.clear();
    this.navCtrl.navigateRoot(['/login']);
    this.presentToast('Successfully logged out!');
  }

}