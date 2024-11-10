import {createPinia} from "pinia";
import {useUserStore} from "./userStore";

const pinia = createPinia();
pinia.use(useUserStore(pinia));

export default pinia;
