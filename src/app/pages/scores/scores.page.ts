import { Component, OnInit } from '@angular/core';
import { Router, ActivatedRoute } from '@angular/router';
import { ToastController, LoadingController, AlertController, NavController } from "@ionic/angular";
import { AccessProviders } from "../../providers/access-providers";
import { Storage } from "@ionic/storage";

@Component({
  selector: 'app-scores',
  templateUrl: './scores.page.html',
  styleUrls: ['./scores.page.scss'],
})
export class ScoresPage implements OnInit {

  private score1: Number = 0;
  private score2: Number = 0;

  round_id: any;
  school_id: any;
  school_name: any;
  student_id: any;
  student_name: any;

  constructor(
    private router: Router,
    private route: ActivatedRoute,
    private toastCtrl: ToastController,
    private loadingCtrl: LoadingController,
    private alertCtrl: AlertController,
    private navCtrl: NavController,
    private accsPrvds: AccessProviders,
    private storage: Storage
  ) { }

  ngOnInit() {
    this.loadStudentDetails();
  }

  ionViewDidEnter() {
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

}
