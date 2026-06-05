<?php
namespace PackageDelivery\Enums;

enum PackageStatus: string {
    case NOT_DELIVERED = 'Not delivered';
    case DELIVERING = 'Delivering';
    case DELIVERED = 'Delivered';
} 