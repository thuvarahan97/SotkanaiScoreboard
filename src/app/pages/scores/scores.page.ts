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
  student_order: number;

  grading_rubric;

  datastorage: any;
  judge_id: string;

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
      {'title':'பொருள்', 'ngmodel':'score_1', 'maxScore':30, 'maxScore1':50, 'maxScore2':40},
      {'title':'சமயோசிதம்', 'ngmodel':'score_2', 'maxScore':30, 'maxScore1':10, 'maxScore2':20},
      {'title':'அழகியல்', 'ngmodel':'score_3', 'maxScore':10, 'maxScore1':10, 'maxScore2':10},
      {'title':'தொனி', 'ngmodel':'score_4', 'maxScore':10, 'maxScore1':10, 'maxScore2':10},
      {'title':'நிலை', 'ngmodel':'score_5', 'maxScore':10, 'maxScore1':10, 'maxScore2':10},
      {'title':'மொழிவளம்', 'ngmodel':'score_6', 'maxScore':10, 'maxScore1':10, 'maxScore2':10}
    ];

    this.grading_rubric.forEach(element => {
      element.ngmodel = 0;
    });

    this.storage.get('storage_xxx').then((res)=>{
      this.datastorage = res;
      this.judge_id = this.datastorage.judge_id;
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
      this.student_order = params['student_order'];
    });
  }

  async submitScores() {
    this.confirmSubmit();
  }

  async saveScores() {
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
          key: 'submit_scores',
          judge_id: this.judge_id,
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

  async presentToast(msg) {
    const toast = await this.toastCtrl.create({
      message: msg,
      duration: 1500,
      position: 'bottom'
    });
    toast.present();
  }

  async confirmSubmit() {
    const alert = await this.alertCtrl.create({
      header: 'Confirm!',
      message: 'Are you sure you want to <strong>submit</strong> the scores?',
      buttons: [
        {
          text: 'Yes',
          handler: () => {
            this.saveScores();
          }
        },
        {
          text: 'No',
          role: 'cancel'
        }
      ]
    });

    await alert.present();
  }

  async processLogout() {
    this.storage.clear();
    this.navCtrl.navigateRoot(['/login']);
    this.presentToast('Successfully logged out!');
  }

}
