
export const state = {
  data: [],
  active: 0,
  currentPlan: 'start'
};

export function setData(data) {
  state.data = data;
}

export function next() {
  state.active = (state.active + 1) % state.data.length;
}

export function prev() {
  state.active = (state.active - 1 + state.data.length) % state.data.length;
}

export function setPlan(plan) {
  state.currentPlan = plan;
}