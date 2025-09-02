import { Category } from "./Category";
import { Reaction } from "./Reaction";

export interface Ticket {
    id: number;
    title: string;
    status: string;
    reporter_id: number;
    assignee_id: number | null;
    made_timestamp: string;
    last_update_on: string;
    categories: Category[];
    reactions: Reaction[];
}
