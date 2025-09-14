"use client";
import ArticleFacet from "./ArticleFacet";

export default function GrowboxFacet() {
  const category = process.env.NEXT_PUBLIC_GROWBOX_CATEGORY_ID || "";
  return (
    <ArticleFacet
      category={category}
      selectionKey="growbox"
      title="Growbox"
      queryKey={["growboxArticles"]}
    />
  );
}
