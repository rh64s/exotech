export type ModuleCharacteristic = {
    id: number;
    name: string;
    value: string;
    unit: string | null;
};

type NamedItem = {
    name: string;
};

export type FilterOption = NamedItem & { id: number };

export type CharacteristicFilterOption = FilterOption & {
    unit: string | null;
    values: { id: number; label: string }[];
};

export type CatalogFilterState = {
    types: number[];
    body_zones?: number[];
    characteristic_values: number[];
    min_price: number | null;
    max_price: number | null;
    max_weight_g?: number | null;
    min_total_weight_g?: number | null;
};

export type CatalogProduct = {
    id: number;
    name: string;
    description: string | null;
    price: string | number;
    weight_g: number;
    module_type: NamedItem;
    /** Поле появится, когда у модулей будут изображения. */
    image_url?: string | null;
};

export type CatalogModule = CatalogProduct & {
    body_zone: NamedItem | null;
    characteristics: ModuleCharacteristic[];
    is_in_wishlist?: boolean;
};

export type CatalogFrame = CatalogProduct & { frame_id: number };

export type ProductDetails = CatalogProduct & {
    body_zone?: NamedItem | null;
    attachment_interface?: NamedItem | null;
    characteristics: ModuleCharacteristic[];
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
