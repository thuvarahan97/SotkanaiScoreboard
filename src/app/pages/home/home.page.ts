import { Component, OnInit } from '@angular/core';
import { Router, ActivatedRoute, NavigationExtras, ParamMap } from '@angular/router';
import { ToastController, LoadingController, AlertController, NavController } from "@ionic/angular";
import { AccessProviders } from "../../providers/access-providers";
import { Storage } from "@ionic/storage";

@Component({
  selector: 'app-home',
  templateUrl: './home.page.html',
  styleUrls: ['./home.page.scss'],
})
export class HomePage implements OnInit {

  datastorage: any;
  user_id;

  disabledButton;

  round_id;
  school_id_1;
  school_name_1;
  school_id_2;
  school_name_2;

  school_1;
  school_2;

  constructor(
    private router: Router,
    private activatedRoute: ActivatedRoute,
    private toastCtrl: ToastController,
    private loadingCtrl: LoadingController,
    private alertCtrl: AlertController,
    private navCtrl: NavController,
    private accsPrvds: AccessProviders,
    private storage: Storage
  ) { }

  ngOnInit() {
    this.storage.get('storage_xxx').then((res)=>{
      console.log(res);
      this.datastorage = res;
      this.user_id = this.datastorage.user_id;
      this.disabledButton = false;
    });
  }

  ionViewWillEnter() {
    this.loadStudents();
  }
  
  async processLogout() {
    this.storage.clear();
    this.navCtrl.navigateRoot(['/login']);
    this.presentToast('Successfully logged out!');
  }

  async loadStudents() {
    this.round_id = null;
    this.school_id_1 = "";
    this.school_name_1 = "";
    this.school_id_2 = "";
    this.school_name_2 = "";
    this.school_1 = [];
    this.school_2 = [];

    const loader = await this.loadingCtrl.create({
      message: 'Please wait...',
    });
    loader.present();

    return new Promise(resolve=> {
      let body = {
        aksi: 'load_schools_students',
        user_id: this.user_id
      }

      this.accsPrvds.postData(body, 'process_api.php').subscribe((res:any)=>{
        if (res.result.length > 0) {
          this.round_id = res.result[0]['round_id'];
          this.school_id_1 = res.result[0]['school_id'];
          this.school_name_1 = res.result[0]['school_name'];
          this.school_id_2 = res.result[res.result.length - 1]['school_id'];
          this.school_name_2 = res.result[res.result.length - 1]['school_name'];

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
      position: 'top'
    });
    toast.present();
  }

  doRefresh(event) {
    console.log('Begin async operation');

    setTimeout(() => {
      this.loadStudents();
      console.log('Async operation has ended');
      event.target.complete();
    });
  }

  isStudentEvaluated(judge_id) {
    if (judge_id != null) {
      return true;
    }
    else {
      return false;
    }
  }

}


