import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ColorDialogueComponent } from './color-dialogue.component';

describe('ColorDialogueComponent', () => {
  let component: ColorDialogueComponent;
  let fixture: ComponentFixture<ColorDialogueComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ColorDialogueComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ColorDialogueComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
