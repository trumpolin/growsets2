"use client";

import { ReactNode, useState } from "react";

interface FacetPanelProps {
  id?: string;
  title: string;
  children: ReactNode;
  selectedItems?: string[];
}

export function FacetPanelGroup({ children }: { children: ReactNode }) {
  return <div>{children}</div>;
}

export default function FacetPanel({
  title,
  children,
  selectedItems = [],
}: FacetPanelProps) {
  const [open, setOpen] = useState(false);

  return (
    <div className="mb-2 rounded border">
      <button
        className="flex w-full items-center justify-between bg-gray-100 p-2 font-semibold"
        onClick={() => setOpen((o) => !o)}
      >
        <span>{title}</span>
        <span>{open ? "-" : "+"}</span>
      </button>
      {open ? (
        <div className="p-2">{children}</div>
      ) : selectedItems.length > 0 ? (
        <div className="p-2 text-sm text-gray-600">
          {selectedItems.slice(0, 3).join(", ")}
          {selectedItems.length > 3 && " …"}
        </div>
      ) : null}
    </div>
  );
}
