import { Component, OnInit } from '@angular/core';
import { Router, ActivatedRoute } from '@angular/router';
import { ToastController, LoadingController, AlertController, NavController } from "@ionic/angular";
import { AccessProviders } from "../../providers/access-providers";
import { Storage } from "@ionic/storage";
import { Network } from "@ionic-native/network/ngx";
import { ScreenOrientation } from '@ionic-native/screen-orientation/ngx';

@Component({
  selector: 'app-scores',
  templateUrl: './scores.page.html',
  styleUrls: ['./scores.page.scss'],
})
export class ScoresPage implements OnInit {
  round_id: any;
  school_id: any;
  school_name: any;
  student_id: any;
  student_name: any;

  grading_rubric;

  datastorage: any;
  user_id: string;

  connection_status: Boolean = true;

  constructor(
    private router: Router,
    private route: ActivatedRoute,
    private toastCtrl: ToastController,
    private loadingCtrl: LoadingController,
    private alertCtrl: AlertController,
    private navCtrl: NavController,
    private accsPrvds: AccessProviders,
    private storage: Storage,
    public network: Network,
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
    this.grading_rubric = [
      {'title':'Organization & Clarity', 'ngmodel':'score_1'},
      {'title':'Use of Argument', 'ngmodel':'score_2'},
      {'title':'Presentation Style', 'ngmodel':'score_3'}
    ];

    this.grading_rubric.forEach(element => {
      element.ngmodel = 0;
    });

    this.storage.get('storage_xxx').then((res)=>{
      this.datastorage = res;
      this.user_id = this.datastorage.user_id;
    });

    this.loadStudentDetails();
  }

  async loadStudentDetails() {
    this.route.queryParams.subscribe(params => {
      this.round_id = params['round_id'];
      this.school_id = params['school_id'];
      this.school_name = params['school_name'];
      this.student_id = params['student_id'];
      this.student_name = params['student_name'];
    });
  }

  async submitScores() {
    var emptyScores = 0;
    this.grading_rubric.forEach(element => {
      if (element.ngmodel == 0) {
        emptyScores += 1;
      };
    });

    if (emptyScores > 0){
      this.presentToast('Any grading criteria cannot have 0 score!')
    }
    else {
      const loader = await this.loadingCtrl.create({
        message: 'Please wait...',
      });
      loader.present();

      return new Promise(resolve=> {
        let body = {
          aksi: 'submit_scores',
          user_id: this.user_id,
          round_id: this.round_id,
          school_id: this.school_id,
          student_id: this.student_id,
        }

        for (var i = 0; i < this.grading_rubric.length; i++) {
          body['score_' + (i+1).toString()] = this.grading_rubric[i].ngmodel;
        }

        this.accsPrvds.postData(body, 'process_api.php').subscribe((res:any)=>{
          if(res.success == true){
            loader.dismiss();
            this.presentToast('Saved scores successfully!');
            this.navCtrl.navigateRoot(['/home']);
          }
          else {
            loader.dismiss();
            this.presentToast('Unable to save scores!');
          }
        },(err)=>{
          loader.dismiss();
          this.presentToast('Unable to save scores!');
        })
      });
    }
  }

  async presentToast(a) {
    const toast = await this.toastCtrl.create({
      message: a,
      duration: 1500,
      position: 'bottom'
    });
    toast.present();
  }

  async processLogout() {
    this.storage.clear();
    this.navCtrl.navigateRoot(['/login']);
    this.presentToast('Successfully logged out!');
  }

}
