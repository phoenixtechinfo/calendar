import {Component, OnInit, ViewChild, ChangeDetectionStrategy, ChangeDetectorRef} from '@angular/core';
import {FullCalendarComponent} from '@fullcalendar/angular';
import {EventInput} from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGrigPlugin from '@fullcalendar/timegrid';
import interactionPlugin from '@fullcalendar/interaction'; // for dateClick
import {MatDialog, MatDialogConfig} from '@angular/material';
import {EventComponent} from '../event/event.component';
import {EventService} from '../services/event.service';
import {ViewEventComponent} from '../event/view-event/view-event.component';
import {FormControl} from '@angular/forms';
import {MomentDateAdapter, MAT_MOMENT_DATE_ADAPTER_OPTIONS} from '@angular/material-moment-adapter';
import {DateAdapter, MAT_DATE_FORMATS, MAT_DATE_LOCALE} from '@angular/material/core';
import {MatDatepicker} from '@angular/material/datepicker';
import { Globals } from '../shared/globals';
import * as moment from 'moment';


export const MY_FORMATS = {
    parse: {
        dateInput: 'MM/YYYY',
    },
    display: {
        dateInput: 'MMM YYYY',
        monthYearLabel: 'MMM YYYY',
        dateA11yLabel: 'LL',
        monthYearA11yLabel: 'MMMM YYYY',
    },
};

@Component({
    selector: 'schedule-view',
    templateUrl: './schedule.component.html',
    styleUrls: ['./schedule.component.scss'],
    changeDetection: ChangeDetectionStrategy.OnPush,
    providers: [
        {
            provide: DateAdapter,
            useClass: MomentDateAdapter,
            deps: [MAT_DATE_LOCALE, MAT_MOMENT_DATE_ADAPTER_OPTIONS]
        },
        {provide: MAT_DATE_FORMATS, useValue: MY_FORMATS},
    ],
})

export class ScheduleComponent implements OnInit {

    @ViewChild('calendar') calendarComponent: FullCalendarComponent;

    constructor(private dialog: MatDialog, private event_service: EventService, private changeDetection: ChangeDetectorRef, private globals: Globals) {
        this.subscription = this.event_service.currentDate.subscribe(data => {this.selectedDate = data.date; (data.reload?(this.pageLoadInit = 1):'');  (data.reload?this.getAllEvents():'');});
        this.currentDate = moment();
        this.imgUrl = this.globals.imgUrl;
        this.baseUrl = this.globals.baseUrl;
    }

    ngOnDestroy() {
        this.subscription.unsubscribe();
    }

    ngOnInit() {
        this.getAllBanners();
        this.getAllEvents();
        //this.getScheduleViewData(this.selectedDate);
    }

    imgUrl:string;
    baseUrl:string;
    subscription:any;
    pageLoadInit = 1;
    calendarVisible = true;
    showmodel: boolean;
    date: string = '';
    calendarPlugins = [dayGridPlugin, timeGrigPlugin, interactionPlugin];
    calendarWeekends = true;
    calendarEvents: EventInput[] = [];
    selectedDate: any;
    currentDate: any;
    scheduleViewData: any = [];
    items: any = [];
    localAfterBeforeWeeks = 20;
    scrollThreshold = 100;
    minLoadedDate: any;
    maxLoadedDate: any;
    bannerData: any;
    defaultBanner: any;

    getScheduleViewData(date) {
        this.minLoadedDate = moment(date);
        this.maxLoadedDate = moment(date);
        this.scheduleViewData = [];
        this.scheduleViewData[moment(date).year() + '-' + moment(this.minLoadedDate).format('ww')] = this.getWeekData(date);
        this.loadPreviousWeeksDetails();
        this.loadNextWeeksDetails();
        this.changeDetection.detectChanges();
        setTimeout(function () {
            var elementExists = document.getElementById(moment(date).format('YYYY-MM-DD'));
            if (elementExists) {
                document.getElementById('schedule-view').scrollTop = document.getElementById(moment(date).format('YYYY-MM-DD')).offsetTop - 70;
            }
        },1000);
    }

    getWeekData(date) {
        let data: any = {};
        data.weekStartDate = moment(date).startOf('week');
        data.weekEndDate = moment(date).endOf('week');
        data.weekTitle = moment(data.weekStartDate).format('DD MMM') + ' - ' + moment(data.weekEndDate).format('DD MMM');
        data.daysData = this.getWeekDaysByDate(date);
        return data;
    }

    getWeekDaysByDate(dateParam) {
        let date: any = moment(dateParam), weeklength = 7, result = [];
        date = date.startOf('week')
        while (weeklength--) {
            let dayData: any = {};
            dayData.id = moment(date).year() + '-' + moment(date).week();
            dayData.date = moment(date);
            dayData.dayName = moment(date).format('ddd');
            dayData.dayNumber = moment(date).format('DD');
            dayData.keyValue = moment(date).format('YYYY-MM-DD');
            dayData.currentDate = moment().isSame(date, 'd') ? true : false;
            dayData.events = this.getEventsByDate(date);

            if (parseInt(moment(date).format('DD')) == 1) {
                let monthName = moment(date).format('MMMM').toLocaleLowerCase();
                dayData.displayBanner = 1;
                if(this.bannerData) {
                    let bannerIndex = this.bannerData.findIndex((item) => item.month == monthName);
                    if (bannerIndex != -1) {
                        dayData.bannerImage = this.imgUrl + this.bannerData[bannerIndex].image;
                    } else {

                        dayData.bannerImage = this.baseUrl + this.defaultBanner;
                    }
                } else {
                    dayData.bannerImage = this.baseUrl + this.defaultBanner;
                }
                dayData.bannerTitle = moment(date).format('MMMM Y')
            }
            result.push(dayData);
            date.add(1, 'day');
        }
        return result;
    }

    refreshEventData(){
        for (var key in this.scheduleViewData) {
            this.scheduleViewData[key].daysData.forEach((dayVal,dayKey) => {
                dayVal.events = this.getEventsByDate(dayVal.date);
            })
        }
        this.changeDetection.detectChanges();
    }
    getEventsByDate(date){
        var events = [];
        this.calendarEvents.forEach((value, index) => {
            let item = { ...value };
            var isStartDateInRange = moment(item.start).isBetween(moment(date).startOf('day'), moment(date).endOf('day'));
            var isEndDateInRange = moment(item.end).isBetween(moment(date).startOf('day'), moment(date).endOf('day'));
            var isDateInRange = moment(date).isBetween(moment(item.start).startOf('day'), moment(item.end).endOf('day'));
            var dayDiff = moment(item.end).endOf('day').diff(moment(item.start).startOf('day'), 'days');
            var currentDayNumber = moment(date).endOf('day').diff(moment(item.start).startOf('day'), 'days');
            if (isDateInRange || moment(item.start).isSame(date, 'd') || moment(item.end).isSame(date, 'd')) {
                if (moment(item.start).isSame(date) && moment(item.end).isSame(date)) {
                    item.dayNumberTitle = '';
                    item.dayTimeTitle = '';
                }
                else if (isStartDateInRange && isEndDateInRange) {
                    item.dayNumberTitle = '';
                    item.dayTimeTitle = moment(item.start).format('hh:mm A') + ' - ' + moment(item.end).format('hh:mm A');
                }
                else {
                    item.dayNumberTitle = (currentDayNumber + 1) + '/' + (dayDiff + 1);
                    if (moment(item.start).isSame(date) && isEndDateInRange) {
                        item.dayNumberTitle = '';
                        item.dayTimeTitle = moment(item.start).format('hh:mm A') + ' - ' + moment(item.end).format('hh:mm A');
                    }
                    else if (isStartDateInRange && moment(item.end).isSame(date)) {
                        item.dayNumberTitle = '';
                        item.dayTimeTitle = moment(item.start).format('hh:mm A') + ' - ' + moment(item.end).format('hh:mm A');
                    }
                    else if (moment(item.start).isSame(date)) {
                        item.dayTimeTitle = '';
                    } else if(isStartDateInRange) {
                        item.dayTimeTitle = moment(item.start).format('hh:mm A');
                    } else if(isEndDateInRange) {
                        item.dayTimeTitle = 'Until ' + moment(item.end).format('hh:mm A');
                    } else {
                        item.dayTimeTitle = '';
                    }
                }
                events.push(item);
            }
        });
        return events;
    }


    loadPreviousWeeksDetails() {
        for (let i = 1; i <= this.localAfterBeforeWeeks; i++) {
            this.minLoadedDate.subtract(1, 'weeks');
            this.scheduleViewData[this.minLoadedDate.endOf('week').year() + '-' + moment(this.minLoadedDate).format('ww')] = this.getWeekData(this.minLoadedDate);
        }
    }

    loadNextWeeksDetails() {
        for (let i = 1; i <= this.localAfterBeforeWeeks; i++) {
            this.maxLoadedDate.add(1, 'weeks');
            this.scheduleViewData[this.maxLoadedDate.endOf('week').year() + '-' + moment(this.maxLoadedDate).format('ww')] = this.getWeekData(this.maxLoadedDate);
        }
    }

    scrollHandler(event) {
        var target = event.target || event.srcElement || event.currentTarget;
        var scrolled = target.scrollTop;
        var height = target.scrollHeight - target.offsetHeight;
        var lastScrollHeight = target.scrollHeight;
        var previousScrollHeightMinusTop = event.target.scrollHeight - event.target.scrollTop
        if (height - scrolled < this.scrollThreshold) {
            this.loadNextWeeksDetails();
        }

        if (target.scrollTop < this.scrollThreshold) {
            this.loadPreviousWeeksDetails();
            this.changeDetection.detectChanges();
            event.target.scrollTop = event.target.scrollHeight - previousScrollHeightMinusTop;
            event.target.click();
        }

        var scheduleViewOffsetTop = target.offsetTop;
        var topElement = null;
        var beforeTopElement = null;
        document.querySelectorAll("#schedule-view .date-identify").forEach(function (item1) {
            let item  = <HTMLElement>item1;
            var totalOffsetTop =  item.offsetTop - target.scrollTop - scheduleViewOffsetTop - 7;
            if(totalOffsetTop<=0 && (totalOffsetTop + item.clientHeight) >= 0) {
                topElement = item.id;
            } else {
                if(totalOffsetTop<=0){
                    beforeTopElement = item.id;
                }
            }

        });
        if(topElement){
            this.event_service.changeCurrentDate(moment(topElement), 0);
        } else {
            this.event_service.changeCurrentDate(moment(beforeTopElement), 0);
        }

    }

    toggleVisible() {
        this.calendarVisible = !this.calendarVisible;
    }

    toggleWeekends() {
        this.calendarWeekends = !this.calendarWeekends;
    }

    //Function to get all the events
    getAllEvents() {
        this.event_service.getAllEvents()
            .subscribe(res => {
                this.calendarEvents = [];
                res['data'].forEach(obj => {
                    let data: any = {};
                    data.id = obj.id;
                    data.title = obj.title;
                    data.start = new Date(obj.start_datetime);
                    data.end = new Date(obj.end_datetime);
                    data.color = obj.color;
                    data.textColor = 'white';
                    this.calendarEvents.push(data);
                });
                if(this.pageLoadInit) {
                    this.getScheduleViewData(this.selectedDate);
                } else {
                    this.refreshEventData();
                }
                this.pageLoadInit = 0;
            }, err => {
                console.log('err', err);
            })
    }

    getAllBanners() {
        this.event_service.getAllBanners()
            .subscribe(res => {
                this.bannerData = res['data'];
                this.defaultBanner = res['defaultBanner'];
            }, err => {
                console.log('error', err);
            });
    }

    createEvent(arg) {

        const dialogConfig = new MatDialogConfig();

        dialogConfig.disableClose = true;
        dialogConfig.autoFocus = true;

        dialogConfig.data = {
            type: arg
        };

        // this.dialog.open(UserdialogueComponent, dialogConfig);

        const dialogRef = this.dialog.open(EventComponent, dialogConfig);

        dialogRef.afterClosed().subscribe(
            data => {
                if (data == 200) {
                    this.getAllEvents();
                }
            }
        );

    }

    hide() {
        this.showmodel = false;
    }

    getEventDetails(event) {
        const dialogConfig = new MatDialogConfig();

        dialogConfig.disableClose = true;
        dialogConfig.autoFocus = true;

        dialogConfig.data = {
            id: event.id
        };

        // this.dialog.open(UserdialogueComponent, dialogConfig);

        const dialogRef = this.dialog.open(ViewEventComponent, dialogConfig);

        dialogRef.afterClosed().subscribe(
            data => {
                if (data == 200) {
                    this.getAllEvents();
                }
            }
        );
    }

    //Function to get the color code
    selectColor(color) {
        switch (color) {
            case 'tometo' :
                return '#ff6347';
                break;
            case 'tangerine' :
                return '#f28500';
                break;
            case 'banana' :
                return '#ffe135';
                break;
            case 'basil' :
                return '#579229';
                break;
            case 'sage' :
                return '#77815c';
                break;
            case 'peacock' :
                return '#33A1C9';
                break;
            case 'blueberry' :
                return '#4f86f7';
                break;
            case 'lavander' :
                return '#b57edc';
                break;
            case 'grape' :
                return '#6f2da8';
                break;
            case 'flamingo' :
                return '#fc8eac';
                break;
            case 'graphite' :
                return '#383428';
                break;
            default :
                return '#0000FF';
                break;
        }
    }

}
