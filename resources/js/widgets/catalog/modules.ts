export type ModuleCategory = {
    id: number;
    name: string;
    parent_id?: number | null;
};

export type ModuleType = {
    id: number;
    name: string;
    description: string | null;
    category: ModuleCategory | null;
};

export type ModuleCharacteristic = {
    id: number;
    name: string;
    value: string;
    unit: string | null;
    data_type: string;
};

export type ModuleSummary = {
    id: number;
    name: string;
};

export type CatalogModule = {
    id: number;
    name: string;
    description: string | null;
    price: string | number;
    weight_g: number;
    frame_id: number | null;
    module_type: ModuleType;
    body_zone: ModuleSummary | null;
    characteristics: ModuleCharacteristic[];
    compatible_modules: ModuleSummary[];
    created_at: string | null;
    updated_at: string | null;
    /** Поле появится, когда у модулей будут изображения. */
    image_url?: string | null;
};

const priceFormatter = new Intl.NumberFormat('ru-RU', {
    maximumFractionDigits: 0,
});

/**
 * Форматирует цену из decimal-строки бэкенда в читаемый вид.
 */
export function formatPrice(value: string | number): string {
    const price = Number(value);

    return Number.isFinite(price)
        ? priceFormatter.format(price)
        : String(value);
}
