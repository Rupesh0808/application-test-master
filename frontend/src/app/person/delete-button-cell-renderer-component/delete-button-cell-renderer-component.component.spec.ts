import { ComponentFixture, TestBed } from '@angular/core/testing';

import { DeleteButtonCellRendererComponentComponent } from './delete-button-cell-renderer-component.component';

describe('DeleteButtonCellRendererComponentComponent', () => {
  let component: DeleteButtonCellRendererComponentComponent;
  let fixture: ComponentFixture<DeleteButtonCellRendererComponentComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ DeleteButtonCellRendererComponentComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(DeleteButtonCellRendererComponentComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
