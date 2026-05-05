import { useState } from 'react';
import { Row, Col, ColorPicker, Button, notification } from 'antd';

const COLOR_FIELDS = [
    { key: 'primary', label: 'Primary', cssVar: '--boldpo-preset-color-primary', default: '#126bf0' },
    { key: 'secondary', label: 'Secondary', cssVar: '--boldpo-preset-color-secondary', default: '#5096ff' },
    { key: 'tertiary', label: 'Tertiary', cssVar: '--boldpo-preset-color-tertiary', default: '#f3f3f3' },
    { key: 'white', label: 'White', cssVar: '--boldpo-preset-color-white', default: '#ffffff' },
    { key: 'contrast_1', label: 'Contrast 1', cssVar: '--boldpo-preset-color-contrast-1', default: '#1e1e1e' },
    { key: 'contrast_2', label: 'Contrast 2', cssVar: '--boldpo-preset-color-contrast-2', default: '#11111194' },
    { key: 'border', label: 'Border', cssVar: '--boldpo-preset-color-border', default: '#8383831f' },
];

const toCssColor = (value) => {
    if (!value) return '';
    if (typeof value === 'string') return value;
    if (typeof value.toHexString === 'function') {
        const alpha = typeof value.toHsb === 'function' ? value.toHsb().a : 1;
        return alpha < 1 ? value.toHexString(true) : value.toHexString();
    }
    return String(value);
};

const applyColorsToRoot = (colors) => {
    const root = document.documentElement;
    COLOR_FIELDS.forEach(({ key, cssVar }) => {
        if (colors[key]) {
            root.style.setProperty(cssVar, colors[key]);
        }
    });
};

export default function Settings() {
    const initial = COLOR_FIELDS.reduce((acc, f) => {
        acc[f.key] = (boldpo.colors && boldpo.colors[f.key]) || f.default;
        return acc;
    }, {});

    const [colors, setColors] = useState(initial);
    const [saving, setSaving] = useState(false);

    const handleChange = (key) => (value) => {
        const next = toCssColor(value);
        setColors((prev) => {
            const updated = { ...prev, [key]: next };
            applyColorsToRoot(updated);
            return updated;
        });
    };

    const handleSave = () => {
        setSaving(true);
        fetch(boldpo.rest_url + 'colors', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-WP-Nonce': boldpo.nonce,
            },
            body: JSON.stringify({ colors }),
        })
            .then((res) => res.json())
            .then((data) => {
                if (data && data.status === 'success') {
                    boldpo.colors = data.colors || colors;
                    notification.success({
                        message: 'Colors Saved',
                        description: 'Color palette has been updated.',
                        duration: 2,
                    });
                } else {
                    notification.error({
                        message: 'Save Failed',
                        description: 'Could not save colors. Please try again.',
                        duration: 2,
                    });
                }
            })
            .catch(() => {
                notification.error({
                    message: 'Network Error',
                    description: 'Could not reach the server.',
                    duration: 2,
                });
            })
            .finally(() => setSaving(false));
    };

    const handleReset = () => {
        const defaults = COLOR_FIELDS.reduce((acc, f) => {
            acc[f.key] = f.default;
            return acc;
        }, {});
        setColors(defaults);
        applyColorsToRoot(defaults);
    };

    return (
        <div className="boldpo-options-content">
            <h1 className="boldpo-options-title">Settings</h1>
            <h2 style={{ fontSize: 18, fontWeight: 600, marginTop: 0 }}>Color Palette</h2>
            <p style={{ marginTop: 0, color: '#555' }}>
                These colors are applied dynamically to the front-end CSS variables defined in <code>:root</code>.
            </p>

            <Row gutter={[16, 16]} style={{ marginTop: 16 }}>
                {COLOR_FIELDS.map((field) => (
                    <Col xs={24} sm={12} md={8} key={field.key}>
                        <div className="boldpo-color-field" style={{ display: 'flex', alignItems: 'center', gap: 12, padding: '10px 12px', background: '#f7f8fb', borderRadius: 8 }}>
                            <ColorPicker
                                value={colors[field.key]}
                                onChange={handleChange(field.key)}
                                format="hex"
                                showText
                            />
                            <div style={{ display: 'flex', flexDirection: 'column', lineHeight: 1.2 }}>
                                <strong>{field.label}</strong>
                            </div>
                        </div>
                    </Col>
                ))}
            </Row>

            <div style={{ marginTop: 24, display: 'flex', gap: 8 }}>
                <Button type="primary" onClick={handleSave} loading={saving}>Save Changes</Button>
                <Button onClick={handleReset} disabled={saving}>Reset to Defaults</Button>
            </div>
        </div>
    );
}
